<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperiencePointStatus extends Model
{
    use HasFactory;

    protected $table = 'experience_point_statuses';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
