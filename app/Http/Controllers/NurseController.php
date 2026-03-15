<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NurseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Nurse::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nic', 'like', '%' . $search . '%');
        }

        $nurses = $query->latest()->paginate(10)->withQueryString();

        return view('nurses.index', compact('nurses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nurses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic' => 'required|string|max:20|unique:nurses,nic',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'date_of_birth' => 'nullable|date',
            'school_or_university' => 'nullable|string|max:255',
            'batch' => 'nullable|string|max:255',
        ]);

        \App\Models\Nurse::create($validated);

        return redirect()->route('nurses.index')->with('success', 'Nurse successfully completely registered.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Nurse $nurse)
    {
        $nurse->load('permanentRegistration');
        return view('nurses.show', compact('nurse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Nurse $nurse)
    {
        return view('nurses.edit', compact('nurse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Nurse $nurse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nic' => ['required', 'string', 'max:20', \Illuminate\Validation\Rule::unique('nurses')->ignore($nurse->id)],
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'date_of_birth' => 'nullable|date',
            'school_or_university' => 'nullable|string|max:255',
            'batch' => 'nullable|string|max:255',
        ]);

        $nurse->update($validated);

        return redirect()->route('nurses.show', $nurse)->with('success', 'Nurse profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Nurse $nurse)
    {
        $nurse->delete();

        return redirect()->route('nurses.index')->with('success', 'Nurse record deleted successfully.');
    }
}
