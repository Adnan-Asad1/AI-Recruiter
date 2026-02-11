<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interviewer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_position',
        'job_description',
        'duration',
        'interview_type',
        'num_questions',
        'question',
    ];

    // Relation with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversations()
    {
        return $this->hasOne(Conversation::class);
    }
   
}
