<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $with = ['situation'];

    public function situation() : BelongsTo
    {
        return $this->belongsTo(Situation::class);
    }

    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
