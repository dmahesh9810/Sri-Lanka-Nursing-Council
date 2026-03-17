<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle global NIC search query.
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|max:50'
        ]);

        $nic = trim($request->input('q'));
        
        // Normalize NIC: remove spaces and convert to uppercase for consistency
        $nic = strtoupper(str_replace(' ', '', $nic));

        $nurse = Nurse::where('nic', $nic)->first();

        if ($nurse) {
            return redirect()->route('nurses.show', $nurse->id);
        }

        return redirect()->back()->with('error', "No nurse found with NIC: {$nic}. Please check the number and try again.");
    }
}
