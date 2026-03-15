<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermanentRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\PermanentRegistration::with('nurse');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('nurse', function ($q) use ($search) {
                $q->where('nic', 'like', '%' . $search . '%');
            })->orWhere('perm_registration_no', 'like', '%' . $search . '%');
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();

        return view('permanent_registrations.index', compact('registrations'));
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
                return back()->with('error', 'Nurse not found.');
            }

            if (\App\Models\PermanentRegistration::where('nurse_id', $nurse->id)->exists()) {
                return back()->with('error', 'Permanent registration already exists.');
            }
        }

        return view('permanent_registrations.create', compact('nurse'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nurse_id' => 'required|exists:nurses,id|unique:permanent_registrations,nurse_id',
            'perm_registration_no' => 'required|string|max:255|unique:permanent_registrations,perm_registration_no',
            'perm_registration_date' => 'required|date',
            'appointment_date' => 'nullable|date',
            'grade' => 'nullable|string|max:255',
            'present_workplace' => 'nullable|string|max:255',
            'slmc_no' => 'nullable|string|max:255',
            'slmc_date' => 'nullable|date',
        ]);

        \App\Models\PermanentRegistration::create($validated);

        return redirect()->route('permanent-registrations.index')->with('success', 'Permanent Registration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\PermanentRegistration $permanentRegistration)
    {
        $permanentRegistration->load('nurse');
        return view('permanent_registrations.show', compact('permanentRegistration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\PermanentRegistration $permanentRegistration)
    {
        $permanentRegistration->load('nurse');
        return view('permanent_registrations.edit', compact('permanentRegistration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\PermanentRegistration $permanentRegistration)
    {
        $validated = $request->validate([
            'nurse_id' => [
                'required',
                'exists:nurses,id',
                \Illuminate\Validation\Rule::unique('permanent_registrations')->ignore($permanentRegistration->id)
            ],
            'perm_registration_no' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('permanent_registrations')->ignore($permanentRegistration->id)
            ],
            'perm_registration_date' => 'required|date',
            'appointment_date' => 'nullable|date',
            'grade' => 'nullable|string|max:255',
            'present_workplace' => 'nullable|string|max:255',
            'slmc_no' => 'nullable|string|max:255',
            'slmc_date' => 'nullable|date',
        ]);

        $permanentRegistration->update($validated);

        return redirect()->route('permanent-registrations.show', $permanentRegistration)->with('success', 'Permanent Registration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\PermanentRegistration $permanentRegistration)
    {
        $permanentRegistration->delete();

        return redirect()->route('permanent-registrations.index')->with('success', 'Permanent Registration deleted successfully.');
    }
}
