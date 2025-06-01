<?php
namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    // public function index()
    // {
    //     $data = University::latest()->paginate(5);
    //     return view('index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 5);
    // }

    public function create()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name'        => 'required|unique:students,user_name',
            'full_name'        => 'required',
            'phone'            => 'required',
            'whatsup_number'   => 'required',
            'address'          => 'required',
            'password'         => 'required|min:8',
            'email'            => 'required|email|unique:students,email',
            'student_img'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = time() . '.' . $request->student_img->extension();
        $request->student_img->move(public_path('images'), $imageName);

        University::create([
            'user_name'       => $request->user_name,
            'full_name'       => $request->full_name,
            'phone'           => $request->phone,
            'whatsup_number'  => $request->whatsup_number,
            'address'         => $request->address,
            'password'        => bcrypt($request->password),
            'email'           => $request->email,
            'student_img'     => $imageName,
        ]);

        return redirect()->route('universities.index')->with('success', 'Student added successfully.');
    }

    // public function show(University $university)  //show students in webpage that stored in DB
    // {
    //     return view('show', compact('university'));
    // }

    // public function edit(University $university) // to edit student data
    // {
    //     return view('edit', compact('university'));
    // }

    public function update(Request $request, University $university)  //like store not need for view page
    {
        $request->validate([
            'user_name'        => 'required|unique:students,user_name,' . $university->student_id . ',student_id',
            'full_name'        => 'required',
            'phone'            => 'required',
            'whatsup_number'   => 'required',
            'address'          => 'required',
            'email'            => 'required|email|unique:students,email,' . $university->student_id . ',student_id',
            'student_img'      => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = $university->student_img;

        if ($request->hasFile('student_img')) {
            $imageName = time() . '.' . $request->student_img->extension();
            $request->student_img->move(public_path('images'), $imageName);
        }

        $university->update([
            'user_name'       => $request->user_name,
            'full_name'       => $request->full_name,
            'phone'           => $request->phone,
            'whatsup_number'  => $request->whatsup_number,
            'address'         => $request->address,
            'email'           => $request->email,
            'student_img'     => $imageName,
        ]);

        return redirect()->route('universities.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('universities.index')->with('success', 'Student deleted successfully.');
    }
}
