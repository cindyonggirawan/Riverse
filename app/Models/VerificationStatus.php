<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationStatus extends Model
{
    use HasFactory;

    protected $table = 'verification_statuses';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
