<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hafalan extends Model
{
    protected $fillable = [
        'santri_id',
        'group_id',
        'surah_name',
        'start_ayah',
        'end_ayah',
        'status',
        'target_date',
        'completed_date',
        'notes',
        'score',
        'feedback'
    ];

    protected $casts = [
        'target_date' => 'date',
        'completed_date' => 'date',
        'start_ayah' => 'integer',
        'end_ayah' => 'integer',
        'score' => 'integer',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
