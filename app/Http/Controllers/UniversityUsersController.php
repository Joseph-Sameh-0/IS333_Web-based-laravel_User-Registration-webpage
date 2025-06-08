<?php

namespace App\Http\Controllers;

use App\Models\UniversityUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegistered;


class UniversityUsersController extends Controller
{
    protected UniversityUsers $universityUsersModel;
    protected WhatsAppController $whatsAppController;

    public function __construct(UniversityUsers $universityUsersModel, WhatsAppController $whatsAppController)
    {
        $this->universityUsersModel = $universityUsersModel;
        $this->whatsAppController = $whatsAppController;
    }

    public function index()
    {
        $users = $this->universityUsersModel::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'full_name' => 'required',
                'user_name' => 'required|unique:students,user_name',
                'phone' => 'required|unique:students,phone|regex:/\d{10,15}$/',
                'whatsup_number' => 'required|unique:students,whatsup_number|regex:/^\+?\d{10,15}$/',
                'email' => 'required|email|unique:students,email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
                'student_img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);


            // Create a fake request for WhatsApp check
            $whatsappRequest = new Request(['phone_number' => $request->whatsup_number]);

            // Call the check method
            $whatsappResponse = $this->whatsAppController->check($whatsappRequest);

            // Decode JSON response
            $whatsappData = json_decode($whatsappResponse->getContent(), true);

            // Check if WhatsApp number is valid
            if (!isset($whatsappData['status']) || $whatsappData['status'] !== 'valid') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The WhatsApp number is not valid.',
                    'errors' => [
                        'whatsup_number' => ['The WhatsApp number is not registered or invalid.']
                    ]
                ], 422);
            }

            $imageName = time() . '.' . $request->student_img->extension();
            $request->student_img->move(public_path('images'), $imageName);

            $this->universityUsersModel::create([
                'full_name' => $request->full_name,
                'user_name' => $request->user_name,
                'phone' => $request->phone,
                'whatsup_number' => $request->whatsup_number,
                'address' => $request->address,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'student_img' => $imageName,
            ]);

            //            Mail::to('joseph.sameh.fouad@gmail.com')->send(new NewUserRegistered($request->user_name));
            // Get all admin users
            $admins = $this->universityUsersModel::where('user_role', 'admin')->get();

            // Send email to each admin asynchronously
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new NewUserRegistered($request->user_name));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Student registered successfully!',
                'redirect_url' => route('users.index')
            ], 200);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $originalUserName = $request->input('user_name');

            if (isset($errors['user_name']) && in_array('The user name has already been taken.', $errors['user_name'])) {
                $uniqueSuggestions = [];
                $attempts = 0;
                $maxAttempts = 10;
                $numSuggestions = 3;

                while (count($uniqueSuggestions) < $numSuggestions && $attempts < $maxAttempts) {
                    $randomSuffix = Str::random(3);
                    $suggestedUserName = $originalUserName . $randomSuffix;

                    $isUnique = !$this->universityUsersModel::where('user_name', $suggestedUserName)->exists();

                    if ($isUnique) {
                        $uniqueSuggestions[] = $suggestedUserName;
                    }
                    $attempts++;
                }

                if (!empty($uniqueSuggestions)) {
                    $suggestionMessage = 'The user name has already been taken. Try ' . implode(', ', $uniqueSuggestions) . '.';
                } else {
                    $suggestionMessage = 'The user name has already been taken. Please try another one.';
                }

                $errors['user_name'] = [$suggestionMessage];
            }

            // Return the JSON response with potentially modified errors
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $errors
            ], 422); // HTTP 422 Unprocessable Entity

        }
    }

    public function show(string $user_id)
    {
        $user = $this->universityUsersModel::find($user_id);

        if (!$user) {
            abort(404);
        }
        return view('users.show', compact('user'));
    }

    public function edit(string $user_id) // to edit student data
    {

        $user = $this->universityUsersModel::find($user_id);
        if (!$user) {
            abort(404);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $user_id)
    {
        try {
            $user = $this->universityUsersModel::find($user_id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

//            return response()->json([ //for debugging
//                'status' => 'error',
//                'message' => 'request data',
//                'user_id' => $user_id,
//                'data' => $request->all()
//            ], 422);

            // Verify password first
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password verification failed',
                    'errors' => ['password' => ['The provided password does not match.']]
                ], 422);
            }


            $rules = [
                'full_name' => 'sometimes|required',
                'phone' => 'sometimes|required|unique:students,phone,' . $user_id,
                'whatsup_number' => 'sometimes|required|unique:students,whatsup_number,' . $user_id . '|regex:/^\+?\d{10,15}$/',
                'address' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:students,email,' . $user_id,
                'student_img' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
                'user_role' => 'sometimes|required|in:student,teacher,admin',
                'password' => 'required',
            ];

            // Only validate password fields if they're provided
            if ($request->has('new_password')) {
                $rules['new_password'] = 'required|min:8';
                $rules['confirm_password'] = 'required|same:new_password';
            }

            $request->validate($rules);


            $updateData = [
                'full_name' => $request->full_name ?? $user->full_name,
                'phone' => $request->phone ?? $user->phone,
                'whatsup_number' => $request->whatsup_number ?? $user->whatsup_number,
                'address' => $request->address ?? $user->address,
                'email' => $request->email ?? $user->email,
                'user_role' => $request->user_role ?? $user->user_role,
            ];

            // Handle image upload if provided
            if ($request->hasFile('student_img')) {
                // Delete old image if exists
                if ($user->student_img && file_exists(public_path('images/' . $user->student_img))) {
                    unlink(public_path('images/' . $user->student_img));
                }

                $imageName = time() . '.' . $request->student_img->extension();
                $request->student_img->move(public_path('images'), $imageName);
                $updateData['student_img'] = $imageName;
            }

            // Update password if new password provided
            if ($request->has('new_password')) {
                $updateData['password'] = bcrypt($request->new_password);
            }

            $user->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully!',
                'redirect_url' => route('users.index')
            ], 200);

        } catch (ValidationException $e) {
            $errors = $e->errors();

            //

            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $errors
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $user_id)
    {
        $user = $this->universityUsersModel::find($user_id);
        if (!$user) {
            abort(404);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Student deleted successfully.');
    }
}
