<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermanentRegistration extends Model
{
    protected $fillable = [
        'nurse_id',
        'perm_registration_no',
        'perm_registration_date',
        'appointment_date',
        'grade',
        'present_workplace',
        'slmc_no',
        'slmc_date',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
