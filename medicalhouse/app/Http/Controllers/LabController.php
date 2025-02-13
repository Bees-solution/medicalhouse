<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabTest;
use App\Models\LabCategory;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labTests = LabTest::with('category')->paginate(5);
        //dd($labTests);
        return view('lab.index', compact('labTests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labCategories = LabCategory::all();
        
        return view('lab.create', compact('labCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:lab_tests,name|string|max:255',
            'fname' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'lab_category_id' => 'required|exists:lab_categories,id', // Validate type of test
        ]);

        //$data = $request->except('_token');
        LabTest::create($validated);
            //dd($request->all());
        return redirect()->route('lab.index')->withSuccess('Lab test added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $labTest = LabTest::where('slug', $slug)->firstOrFail(); // Find by slug instead of ID
        return view('lab.show', compact('labTest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $labTest = LabTest::where('slug', $slug)->first();

        if (!$labTest) {
            abort(404, "Lab Test Not Found");
        }

        $labCategories = LabCategory::all();
        return view('lab.edit', compact('labTest', 'labCategories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LabTest $labTest)
    {
        $validated = $request->validate([
            'name' => 'required|unique:lab_tests,name,'.$labTest->id.'|string|max:255',
            'fname' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'lab_category_id' => 'required|exists:lab_categories,id', // Validate type of test
        ]);

        $data = $request->all();
        //$labTest = LabTest::find($slug);
        $labTest->update($data);
        return redirect()->route('lab.edit',$labTest->slug)->withSuccess('Lab Test details updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        // Find the lab test by slug
        $labTest = LabTest::where('slug', $slug)->firstOrFail();

        // Delete the record
        $labTest->delete();

        // Redirect with success message
        return redirect()->route('lab.index')->withSuccess('Lab Test deleted successfully');
    }

}
