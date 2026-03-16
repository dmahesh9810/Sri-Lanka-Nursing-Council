<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemporaryRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\TemporaryRegistration::with('nurse');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('nurse', function ($q) use ($search) {
                $q->where('nic', 'like', '%' . $search . '%');
            })->orWhere('temp_registration_no', 'like', '%' . $search . '%');
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();

        return view('temporary_registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $nurse = null;

        if ($request->filled('nic')) {
            $nurse = \App\Models\Nurse::where('nic', $request->nic)->first();

            if (!$nurse) {
                return back()->with('error', 'Nurse not found. Please register nurse first.');
            }

            if (\App\Models\TemporaryRegistration::where('nurse_id', $nurse->id)->exists()) {
                return back()->with('error', 'Nurse already has a temporary registration.');
            }
        }

        return view('temporary_registrations.create', compact('nurse'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('is_new_nurse')) {
            $nurseData = $request->validate([
                'new_name' => 'required|string|max:255',
                'new_nic' => 'required|string|max:20|unique:nurses,nic',
                'new_phone' => 'nullable|string|max:20',
                'new_gender' => 'nullable|string|max:10',
                'temp_registration_no' => 'required|string|max:255',
                'temp_registration_date' => 'required|date',
                'address' => 'nullable|string|max:500',
                'batch' => 'nullable|string|max:100',
                'school_university' => 'nullable|string|max:255',
                'birth_date' => 'nullable|date',
            ]);

            $nurse = \App\Models\Nurse::create([
                'name' => $nurseData['new_name'],
                'nic' => $nurseData['new_nic'],
                'phone' => $nurseData['new_phone'],
                'gender' => $nurseData['new_gender'],
            ]);

            \App\Models\TemporaryRegistration::create([
                'nurse_id' => $nurse->id,
                'temp_registration_no' => $nurseData['temp_registration_no'],
                'temp_registration_date' => $nurseData['temp_registration_date'],
                'address' => $nurseData['address'],
                'batch' => $nurseData['batch'],
                'school_university' => $nurseData['school_university'],
                'birth_date' => $nurseData['birth_date'],
            ]);
        } else {
            $validated = $request->validate([
                'nurse_id' => 'required|exists:nurses,id|unique:temporary_registrations,nurse_id',
                'temp_registration_no' => 'required|string|max:255',
                'temp_registration_date' => 'required|date',
                'address' => 'nullable|string|max:500',
                'batch' => 'nullable|string|max:100',
                'school_university' => 'nullable|string|max:255',
                'birth_date' => 'nullable|date',
            ]);

            \App\Models\TemporaryRegistration::create($validated);
        }

        $regNo = isset($nurseData) ? $nurseData['temp_registration_no'] : $validated['temp_registration_no'];
        \App\Models\ActivityLog::record('Temporary registration created', "Temporary registration ($regNo) was added to the system.");

        return redirect()->route('temporary-registrations.index')->with('success', 'Temporary Registration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\TemporaryRegistration $temporaryRegistration)
    {
        $temporaryRegistration->load('nurse');
        return view('temporary_registrations.show', compact('temporaryRegistration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\TemporaryRegistration $temporaryRegistration)
    {
        $temporaryRegistration->load('nurse');
        return view('temporary_registrations.edit', compact('temporaryRegistration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\TemporaryRegistration $temporaryRegistration)
    {
        $validated = $request->validate([
            'temp_registration_no' => 'required|string|max:255',
            'temp_registration_date' => 'required|date',
            'address' => 'nullable|string|max:500',
            'batch' => 'nullable|string|max:100',
            'school_university' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'nurse_id' => [
                'required',
                'exists:nurses,id',
                \Illuminate\Validation\Rule::unique('temporary_registrations')->ignore($temporaryRegistration->id)
            ],
        ]);

        $temporaryRegistration->update($validated);

        return redirect()->route('temporary-registrations.show', $temporaryRegistration)->with('success', 'Registration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\TemporaryRegistration $temporaryRegistration)
    {
        $temporaryRegistration->delete();

        return redirect()->route('temporary-registrations.index')->with('success', 'Registration deleted successfully.');
    }
}
