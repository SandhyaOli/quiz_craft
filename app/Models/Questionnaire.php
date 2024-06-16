<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Questionnaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'expiry_date'
    ];

    /**
     * Define a many-to-many relationship with the Question model.
     * This relationship indicates that a questionnaire can contain multiple questions.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'quizcraft.question_questionnaire');
    }

}
