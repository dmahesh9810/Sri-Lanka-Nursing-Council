<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id',
        'temp_registration_no',
        'temp_registration_date',
        'address',
        'batch',
        'school_university',
        'birth_date',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
