<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitatorType extends Model
{
    use HasFactory;

    protected $table = 'fasilitator_types';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
