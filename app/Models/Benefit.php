<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Benefit extends Model
{
    use HasFactory;

    protected $table = 'benefits';
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * Get the level that owns the Benefit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'levelId', 'id');
    }
}
