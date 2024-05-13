<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id', 
        'question_id',
        'value',
        'flagged',
        'score',
        'duration'
    ];

    protected $hidden = [
        'score',
        'created_at',
        'updated_at'
    ];

    public function session() : BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
