<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $users = University::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'user_name' => 'required|unique:students,user_name',
            'phone' => 'required',
            'whatsup_number' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'student_img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Check if the phone number is already in use
        if (University::where('phone', $request->phone)->exists()) {
            return redirect()->back()->withErrors(['phone' => 'Phone number already in use.']);
        }
        // Check if the WhatsApp number is already in use
        if (University::where('whatsup_number', $request->whatsup_number)->exists()) {
            return redirect()->back()->withErrors(['whatsup_number' => 'WhatsApp number already in use.']);
        }
        // Check if the email is already in use
        if (University::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email already in use.']);
        }
        // Check if the username is already in use
        if (University::where('user_name', $request->user_name)->exists()) {
            return redirect()->back()->withErrors(['user_name' => 'Username already in use.']);
        }

        $imageName = time() . '.' . $request->student_img->extension();
        $request->student_img->move(public_path('images'), $imageName);

        University::create([
            'full_name' => $request->full_name,
            'user_name' => $request->user_name,
            'phone' => $request->phone,
            'whatsup_number' => $request->whatsup_number,
            'address' => $request->address,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'student_img' => $imageName,
        ]);

        return redirect()->route('users.index')->with('success', 'Student added successfully.');
    }

    public function show(string $user_id)
    {
        $user = University::find($user_id);

        if (!$user) {
            abort(404);
        }
        return view('users.show', compact('user'));
    }

    public function edit(string $user_id) // to edit student data
    {

        $user = University::find($user_id);
        if (!$user) {
            abort(404);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $user_id)  //like store not need for view page
    {
        $user = University::find($user_id);
        if (!$user) {
            abort(404);
        }

        $request->validate([
            'user_name' => 'required|unique:students,user_name,' . $user->id . ',id',
            'full_name' => 'required',
            'phone' => 'required',
            'whatsup_number' => 'required',
            'address' => 'required',
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

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('users.index')->with('success', 'Student deleted successfully.');
    }
}
