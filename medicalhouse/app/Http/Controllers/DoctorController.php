<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query
        $query = Doctor::query();

        // Check if there's a search term
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('Doc_id', 'like', "%{$search}%");
        }

        // Fetch doctors (filtered or not)
        $doctors = $query->get();

        return view('Doctor.home', compact('doctors'));
    }

    public function create()
    {
        return view('Doctor.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'Type' => 'required|in:Special,Normal',
            'Fee' => 'required|numeric',
            'No_of_patients' => 'required|integer',
            'License' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'Qualification' => 'required|string|max:255',
            'Specialty' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'Description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle image upload
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('doctors', 'public'); // Store in public storage
        }

        // Create a new doctor record
        Doctor::create($data);

        return redirect()->route('doctor.index')->with('success', 'Doctor added successfully.');
    }

    public function show(Doctor $doctor)
    {
        return view('Doctor.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('Doctor.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'Type' => 'required|in:Special,Normal',
            'Fee' => 'required|numeric',
            'No_of_patients' => 'required|integer',
            'License' => 'required|string',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'Qualification' => 'required|string|max:255',
            'Specialty' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'Description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle image upload
        $data = $request->all();
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($doctor->image && Storage::exists('public/' . $doctor->image)) {
                Storage::delete('public/' . $doctor->image);
            }
            $data['image'] = $request->file('image')->store('doctors', 'public');
        }

        // Update the doctor record
        $doctor->update($data);

        return redirect()->route('doctor.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        // Delete the doctor record
        if ($doctor->image && Storage::exists('public/' . $doctor->image)) {
            Storage::delete('public/' . $doctor->image); // Delete image file
        }

        $doctor->delete();

        return redirect()->route('doctor.index')->with('success', 'Doctor deleted successfully.');
    }


public function getDoctorsBySpecialty(Request $request)
    {
        // Validate the request to ensure 'specialty' is present
        $request->validate([
            'specialty' => 'required|string',
        ]);

        // Fetch doctors with the selected specialty
        $doctors = Doctor::where('Specialty', $request->specialty)->get(['Doc_id', 'name']);

        // Return the doctors as JSON
        return response()->json($doctors);
    }

    public function getDoctorFee(Request $request)
    {
        // ✅ Validate request
        if (!isset($request->doctor_id) || empty($request->doctor_id)) {
            return response()->json(['error' => 'Doctor ID is required.'], 400);
        }

        // ✅ Fetch doctor using `Doc_id`
        $doctor = Doctor::where('Doc_id', $request->doctor_id)->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found.'], 404);
        }

        // ✅ Return doctor details
        return response()->json([
            'name' => $doctor->name,
            'specialty' => $doctor->Specialty,
            'fee' => $doctor->Fee
        ]);
    }
}
