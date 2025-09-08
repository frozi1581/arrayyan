<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'address',
        'profile_photo',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function groupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function hafalans(): HasMany
    {
        return $this->hasMany(Hafalan::class);
    }

    public function murajaahs(): HasMany
    {
        return $this->hasMany(Murajaah::class);
    }
}
