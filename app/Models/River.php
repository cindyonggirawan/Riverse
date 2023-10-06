<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class River extends Model
{
    use HasFactory;

    protected $table = 'rivers';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function activity()
    {
        return $this->hasOne(Activity::class, 'activityId', 'id');
    }
}
