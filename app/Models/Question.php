<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'subject', 'options', 'correct_answer'];

    /**
     * The questionnaires that belong to the question.
     */
    public function questionnaires()
    {
        return $this->belongsToMany(Questionnaire::class, 'quizcraft.question_questionnaire');
    }
}
