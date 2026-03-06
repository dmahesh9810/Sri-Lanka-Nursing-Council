<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_id',
        'qualification_type',
        'qualification_number',
        'qualification_date',
        'certificate_printed',
        'certificate_posted',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
