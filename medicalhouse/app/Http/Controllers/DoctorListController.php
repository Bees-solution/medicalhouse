<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorListController extends Controller
{
    public function customerList(Request $request)
    {
        $query = Doctor::query();

        // Search by name or specialty
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('Specialty', 'like', "%{$search}%");
        }

        // Filter by Specialty
        if ($request->has('specialty') && $request->specialty != '') {
            $query->where('Specialty', $request->specialty);
        }

        // Fetch unique specialties for sidebar filter
        $specialties = Doctor::select('Specialty')->distinct()->get();

        // Fetch doctors (filtered by search/specialty if selected)
        $doctors = $query->paginate(10);

        return view('Doctor.dlist', compact('doctors', 'specialties'));
    }

    public function doctorsBySpecialty(Request $request)
    {
        $query = Doctor::query();

        // Filter doctors by selected specialty
        if ($request->has('specialty') && $request->specialty != '') {
            $query->where('Specialty', $request->specialty);
        }

        // Fetch unique specialties for sidebar
        $specialties = Doctor::select('Specialty')->distinct()->get();

        // Fetch doctors from selected specialty
        $doctors = $query->paginate(10);

        return view('Doctor.dlist', compact('doctors', 'specialties'));
    }

     /**
     * Show details of a specific doctor (Dview page).
     */
    public function view($id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('Doctor.dview', compact('doctor'));
    }
}
