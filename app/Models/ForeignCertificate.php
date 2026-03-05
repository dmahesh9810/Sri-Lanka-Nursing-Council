<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForeignCertificate extends Model
{
    protected $fillable = [
        'nurse_id',
        'certificate_type',
        'country',
        'apply_date',
        'certificate_sealed',
        'issue_date',
        'certificate_printed',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
