<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermanentRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id',
        'perm_registration_no',
        'perm_registration_date',
        'appointment_date',
        'grade',
        'present_workplace',
        'slmc_no',
        'slmc_date',
        'certificate_printed',
        'certificate_posted',
    ];

    protected $casts = [
        'certificate_printed' => 'boolean',
        'certificate_posted'  => 'boolean',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
