<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function package() : BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function situations() : HasMany
    {
        return $this->hasMany(Situation::class);
    }

    public function questions() : HasMany
    {
        return $this->hasMany(Question::class);
    }
}
