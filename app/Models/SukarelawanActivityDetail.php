<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SukarelawanActivityDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sukarelawan()
    {
        return $this->belongsTo(Sukarelawan::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
