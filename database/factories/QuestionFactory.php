<?php

namespace Database\Factories;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        $options = [
            $this->faker->word,
            $this->faker->word,
            $this->faker->word,
            $this->faker->word,
        ];

        // Randomly choose one of the options as correct answer
        $correctAnswerIndex = array_rand($options);

        return [
            'question' => $this->faker->sentence,
            'options' => json_encode($options),
            'correct_answer' => $options[$correctAnswerIndex],
            'subject' => $this->faker->randomElement(['physics', 'chemistry']),
        ];
    }
}

