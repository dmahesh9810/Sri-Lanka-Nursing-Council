<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id',
        'certificate_type',
        'country',
        'apply_date',
        'certificate_sealed',
        'issue_date',
        'certificate_printed',
        'printed_at',
        'certificate_number',
    ];

    protected $casts = [
        'certificate_sealed' => 'boolean',
        'certificate_printed' => 'boolean',
        'printed_at' => 'datetime',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
