<?php

namespace App\Http\Controllers;

use App\Models\UniversityUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniversityUsersController extends Controller
{
    public function index()
    {
        $users = UniversityUsers::all();
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
                'phone' => 'required|unique:students,phone',
                'whatsup_number' => 'required|unique:students,whatsup_number|regex:/^\+?\d{10,15}$/',
                'email' => 'required|email|unique:students,email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
                'student_img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imageName = time() . '.' . $request->student_img->extension();
            $request->student_img->move(public_path('images'), $imageName);

            UniversityUsers::create([
                'full_name' => $request->full_name,
                'user_name' => $request->user_name,
                'phone' => $request->phone,
                'whatsup_number' => $request->whatsup_number,
                'address' => $request->address,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'student_img' => $imageName,
            ]);

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

                    $isUnique = !UniversityUsers::where('user_name', $suggestedUserName)->exists();

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
        $user = UniversityUsers::find($user_id);

        if (!$user) {
            abort(404);
        }
        return view('users.show', compact('user'));
    }

    public function edit(string $user_id) // to edit student data
    {

        $user = UniversityUsers::find($user_id);
        if (!$user) {
            abort(404);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $user_id)  //like store not need for view page
    {
        $user = UniversityUsers::find($user_id);
        if (!$user) {
            abort(404);
        }

        $request->validate([
            'user_name' => 'required|unique:students,user_name,' . $user->id . ',id',
            'full_name' => 'required',
            'phone' => 'required', Rule::unique('students', 'phone')->ignore($user->id),
            'whatsup_number' => 'required', Rule::unique('students', 'whatsup_number')->ignore($user->id),
            'email' => 'required|email|unique:students,email,' . $user->id . ',id',
            'current_password' => 'required',
            'password' => 'nullable|min:8',
            'confirm_password' => 'nullable|same:password',
            'student_img' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Check if the current password matches
        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        $imageName = $user->student_img;

        if ($request->hasFile('student_img')) {
            $imageName = time() . '.' . $request->student_img->extension();
            $request->student_img->move(public_path('images'), $imageName);
        }

        $user->update([
            'user_name' => $request->user_name,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'whatsup_number' => $request->whatsup_number,
            'address' => $request->address,
            'email' => $request->email,
            'student_img' => $imageName,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(string $user_id)
    {
        $user = UniversityUsers::find($user_id);
        if (!$user) {
            abort(404);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Student deleted successfully.');
    }
}
