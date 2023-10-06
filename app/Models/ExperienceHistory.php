<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperienceHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sukarelawan(): BelongsTo
    {
        return $this->belongsTo(Sukarelawan::class, 'sukarelawanId', 'id');
    }

    public function fasilitator(): BelongsTo
    {
        return $this->belongsTo(Fasilitator::class, 'fasilitatorId', 'id');
    }
}
