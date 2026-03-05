<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryRegistration extends Model
{
    protected $fillable = [
        'nurse_id',
        'temp_registration_no',
        'temp_registration_date',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
