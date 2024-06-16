<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = ['student_id', 'questionnaire_id', 'question_id', 'answer'];
}
