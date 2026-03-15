<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportLog extends Model
{
    use HasFactory;

    protected $fillable = ['module', 'period'];
}
