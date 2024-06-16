<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    protected $fillable = ['question', 'subject', 'options', 'correct_answer'];

    /**
     * Define a many-to-many relationship with the Questionnaire model.
     * This relationship indicates that a question can belong to multiple questionnaires.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function questionnaires(): BelongsToMany
    {
        return $this->belongsToMany(Questionnaire::class, 'quizcraft.question_questionnaire');
    }
}
