<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForeignCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\ForeignCertificate::with('nurse');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('nurse', function ($q) use ($search) {
                $q->where('nic', 'like', '%' . $search . '%');
            })
                ->orWhere('certificate_type', 'like', '%' . $search . '%')
                ->orWhere('country', 'like', '%' . $search . '%');
        }

        $certificates = $query->latest()->paginate(10)->withQueryString();

        return view('foreign_certificates.index', compact('certificates'));
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
                return back()->with('error', 'Permanent registration required before applying for foreign certificates.');
            }
        }

        return view('foreign_certificates.create', compact('nurse'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nurse_id' => 'required|exists:nurses,id',
            'certificate_type' => 'required|string|in:Verification,Good Standing,Confirmation,Additional Verification',
            'country' => 'required|string|max:255',
            'apply_date' => 'required|date',
            'issue_date' => 'nullable|date|after_or_equal:apply_date',
        ]);

        $validated['certificate_sealed'] = $request->has('certificate_sealed');
        $validated['certificate_printed'] = $request->has('certificate_printed');

        \App\Models\ForeignCertificate::create($validated);

        return redirect()->route('foreign-certificates.index')->with('success', 'Foreign Certificate Application recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\ForeignCertificate $foreignCertificate)
    {
        $foreignCertificate->load('nurse');
        return view('foreign_certificates.show', compact('foreignCertificate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\ForeignCertificate $foreignCertificate)
    {
        $foreignCertificate->load('nurse');
        return view('foreign_certificates.edit', compact('foreignCertificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\ForeignCertificate $foreignCertificate)
    {
        $validated = $request->validate([
            'certificate_type' => 'required|string|in:Verification,Good Standing,Confirmation,Additional Verification',
            'country' => 'required|string|max:255',
            'apply_date' => 'required|date',
            'issue_date' => 'nullable|date|after_or_equal:apply_date',
        ]);

        $validated['certificate_sealed'] = $request->has('certificate_sealed');
        $validated['certificate_printed'] = $request->has('certificate_printed');

        $foreignCertificate->update($validated);

        return redirect()->route('foreign-certificates.show', $foreignCertificate)->with('success', 'Foreign Certificate Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\ForeignCertificate $foreignCertificate)
    {
        $foreignCertificate->delete();

        return redirect()->route('foreign-certificates.index')->with('success', 'Certificate application deleted successfully.');
    }
}
