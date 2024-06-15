<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'expiry_date'
    ];

    /**
     * The questions that belong to the questionnaire.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quizcraft.question_questionnaire');
    }

}
