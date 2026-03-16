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
            $query->where(function($q) use ($search) {
                $q->whereHas('nurse', function ($subQ) use ($search) {
                    $subQ->where('nic', 'like', '%' . $search . '%');
                })->orWhere('perm_registration_no', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('year')) {
            $query->whereYear('perm_registration_date', $request->year);
        }

        if ($request->filled('grade')) {
            $query->where('grade', 'like', '%' . $request->grade . '%');
        }

        if ($request->filled('workplace')) {
            $query->where('present_workplace', 'like', '%' . $request->workplace . '%');
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
        if ($request->has('is_new_nurse')) {
            // Create new nurse inline then create permanent registration
            $nurseData = $request->validate([
                'new_name'              => 'required|string|max:255',
                'new_nic'               => 'required|string|max:20|unique:nurses,nic',
                'new_phone'             => 'nullable|string|max:20',
                'new_gender'            => 'nullable|string|max:10',
                'perm_registration_no'  => 'required|string|max:255|unique:permanent_registrations,perm_registration_no',
                'perm_registration_date'=> 'required|date',
                'appointment_date'      => 'nullable|date',
                'grade'                 => 'nullable|string|max:255',
                'present_workplace'     => 'nullable|string|max:255',
                'address'               => 'nullable|string|max:500',
                'batch'                 => 'nullable|string|max:100',
                'school_university'     => 'nullable|string|max:255',
                'birth_date'            => 'nullable|date',
                'qualification'         => 'nullable|in:Diploma,General Nursing,BSc Nursing',
                'slmc_no'               => 'nullable|string|max:255',
                'slmc_date'             => 'nullable|date',
            ]);

            $nurse = \App\Models\Nurse::create([
                'name'   => $nurseData['new_name'],
                'nic'    => $nurseData['new_nic'],
                'phone'  => $nurseData['new_phone'] ?? null,
                'gender' => $nurseData['new_gender'] ?? null,
            ]);

            \App\Models\PermanentRegistration::create([
                'nurse_id'              => $nurse->id,
                'perm_registration_no'  => $nurseData['perm_registration_no'],
                'perm_registration_date'=> $nurseData['perm_registration_date'],
                'appointment_date'      => $nurseData['appointment_date'] ?? null,
                'grade'                 => $nurseData['grade'] ?? null,
                'present_workplace'     => $nurseData['present_workplace'] ?? null,
                'address'               => $nurseData['address'] ?? null,
                'batch'                 => $nurseData['batch'] ?? null,
                'school_university'     => $nurseData['school_university'] ?? null,
                'birth_date'            => $nurseData['birth_date'] ?? null,
                'qualification'         => $nurseData['qualification'] ?? null,
                'slmc_no'               => $nurseData['slmc_no'] ?? null,
                'slmc_date'             => $nurseData['slmc_date'] ?? null,
            ]);
        } else {
            $validated = $request->validate([
                'nurse_id'              => 'required|exists:nurses,id|unique:permanent_registrations,nurse_id',
                'perm_registration_no'  => 'required|string|max:255|unique:permanent_registrations,perm_registration_no',
                'perm_registration_date'=> 'required|date',
                'appointment_date'      => 'nullable|date',
                'grade'                 => 'nullable|string|max:255',
                'present_workplace'     => 'nullable|string|max:255',
                'address'               => 'nullable|string|max:500',
                'batch'                 => 'nullable|string|max:100',
                'school_university'     => 'nullable|string|max:255',
                'birth_date'            => 'nullable|date',
                'qualification'         => 'nullable|in:Diploma,General Nursing,BSc Nursing',
                'slmc_no'               => 'nullable|string|max:255',
                'slmc_date'             => 'nullable|date',
            ]);

            \App\Models\PermanentRegistration::create($validated);
        }

        $regNo = isset($nurseData) ? $nurseData['perm_registration_no'] : $validated['perm_registration_no'];
        \App\Models\ActivityLog::record('Permanent registration created', "Permanent registration ($regNo) was added to the system.");

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
            'address'           => 'nullable|string|max:500',
            'batch'             => 'nullable|string|max:100',
            'school_university' => 'nullable|string|max:255',
            'birth_date'        => 'nullable|date',
            'qualification'     => 'nullable|in:Diploma,General Nursing,BSc Nursing',
            'slmc_no'           => 'nullable|string|max:255',
            'slmc_date'         => 'nullable|date',
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
