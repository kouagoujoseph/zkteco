<?php

namespace App\Models;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}
