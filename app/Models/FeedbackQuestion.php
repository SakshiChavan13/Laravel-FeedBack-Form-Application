<?php

namespace App\Models;

use App\Models\FeedbackAnswer;
use Illuminate\Database\Eloquent\Model;

class FeedbackQuestion extends Model
{


    protected $fillable = ['title', 'type', 'is_active', 'created_by'];


    public function answers()
    {
        return $this->hasMany(FeedbackAnswer::class);
    }
}
