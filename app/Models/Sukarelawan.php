<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Sukarelawan as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Sukarelawan extends Model
{
    use HasFactory;

    protected $table = 'sukarelawans';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function isSukarelawan()
    {
        return $this->role === 'sukarelawan';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function sukarelawanActivityDetails()
    {
        return $this->hasMany(SukarelawanActivityDetail::class);
    }
}
