<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityStatus extends Model
{
    use HasFactory;

    protected $table = 'activity_statuses';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'activityStatusId', 'id');
    }
}
