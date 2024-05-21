<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $fillable = [
        'package_id', 
        'user_id',
        'redirect_url',
        'completed', 
        'scores', 
        'section_id', 
        'question_id',
        'first_time',
        'last_time',
        'started_at',
        'finished_at'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if(empty($model->id))
                $model->id = uuid_create();
        });
    }

    public function package() : BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function question() : BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
