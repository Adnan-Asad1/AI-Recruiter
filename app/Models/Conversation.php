<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'interviewer_id',
        'name',
        'email',
        'conversation',
    ];

    public function interviewer()
    {
        return $this->belongsTo(Interviewer::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }


}
