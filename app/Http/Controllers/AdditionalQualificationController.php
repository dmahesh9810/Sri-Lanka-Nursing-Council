<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdditionalQualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\AdditionalQualification::with('nurse');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('nurse', function ($q) use ($search) {
                $q->where('nic', 'like', '%' . $search . '%');
            })
                ->orWhere('qualification_type', 'like', '%' . $search . '%')
                ->orWhere('qualification_number', 'like', '%' . $search . '%');
        }

        $qualifications = $query->latest()->paginate(10)->withQueryString();

        return view('additional_qualifications.index', compact('qualifications'));
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

            if (!\App\Models\PermanentRegistration::where('nurse_id', $nurse->id)->exists()) {
                return back()->with('error', 'Permanent registration required before adding qualifications.');
            }
        }

        return view('additional_qualifications.create', compact('nurse'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nurse_id' => 'required|exists:nurses,id',
            'qualification_type' => 'required|string|max:255',
            'qualification_number' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('additional_qualifications')->where(function ($query) use ($request) {
            return $query->where('nurse_id', $request->nurse_id);
        })
            ],
            'qualification_date' => 'required|date',
        ]);

        $validated['certificate_printed'] = $request->has('certificate_printed');
        $validated['certificate_posted'] = $request->has('certificate_posted');

        \App\Models\AdditionalQualification::create($validated);

        return redirect()->route('additional-qualifications.index')->with('success', 'Additional Qualification recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\AdditionalQualification $additionalQualification)
    {
        $additionalQualification->load('nurse');
        return view('additional_qualifications.show', compact('additionalQualification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\AdditionalQualification $additionalQualification)
    {
        $additionalQualification->load('nurse');
        return view('additional_qualifications.edit', compact('additionalQualification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\AdditionalQualification $additionalQualification)
    {
        $validated = $request->validate([
            'qualification_type' => 'required|string|max:255',
            'qualification_number' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('additional_qualifications')->where(function ($query) use ($additionalQualification) {
            return $query->where('nurse_id', $additionalQualification->nurse_id);
        })->ignore($additionalQualification->id)
            ],
            'qualification_date' => 'required|date',
        ]);

        $validated['certificate_printed'] = $request->has('certificate_printed');
        $validated['certificate_posted'] = $request->has('certificate_posted');

        $additionalQualification->update($validated);

        return redirect()->route('additional-qualifications.show', $additionalQualification)->with('success', 'Additional Qualification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\AdditionalQualification $additionalQualification)
    {
        $additionalQualification->delete();

        return redirect()->route('additional-qualifications.index')->with('success', 'Qualification deleted successfully.');
    }
}
