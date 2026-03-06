<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nic',
        'address',
        'phone',
        'gender',
        'date_of_birth',
        'school_or_university',
        'batch',
    ];

    public function temporaryRegistration()
    {
        return $this->hasOne(TemporaryRegistration::class);
    }

    public function permanentRegistration()
    {
        return $this->hasOne(PermanentRegistration::class);
    }

    public function additionalQualifications()
    {
        return $this->hasMany(AdditionalQualification::class);
    }

    public function foreignCertificates()
    {
        return $this->hasMany(ForeignCertificate::class);
    }
}
