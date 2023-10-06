<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SukarelawanActivityDetail extends Model
{
    use HasFactory;

    protected $table = 'sukarelawan_activity_details';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $guarded = [];

    public function sukarelawan(): BelongsTo
    {
        return $this->belongsTo(Sukarelawan::class, 'sukarelawanId', 'id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activityId', 'id');
    }

    public function sukarelawanActivityStatus(): BelongsTo
    {
        return $this->belongsTo(SukarelawanActivityStatus::class, 'sukarelawanActivityStatusId', 'id');
    }
}
