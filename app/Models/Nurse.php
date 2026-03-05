<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $fillable = [
        'name',
        'nic',
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
