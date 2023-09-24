<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Fasilitator extends Model
{
    use HasFactory;

    protected $table = 'fasilitators';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function isFasilitator()
    {
        return $this->role === 'fasilitator';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
