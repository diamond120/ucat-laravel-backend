<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Situation extends Model
{
    use HasFactory;

    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function questions() : HasMany
    {
        return $this->hasMany(Question::class);
    }
}
