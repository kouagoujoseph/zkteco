<?php

namespace App\Models;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
