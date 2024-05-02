<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    use HasFactory;

    public function package() : BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function current_section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function current_question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
