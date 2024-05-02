<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Response extends Model
{
    use HasFactory;

    public function session() : BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
