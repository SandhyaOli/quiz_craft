<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $physicsQuestions = [
            [
                'question' => 'What type of waves are light wave?',
                'options' => json_encode([
                    'Transverse wave',
                    'Longitudinal wave',
                    'Both A & B',
                    'None'
                ]),
                'correct_answer' => 'Transverse wave'
            ],
            [
                'question' => 'A 220 V, 100 W bulb is connected to a 110 V source. Calculate the power consumed by the bulb.',
                'options' => json_encode([
                    '10 W',
                    '15 W',
                    '20 W',
                    '25 W'
                ]),
                'correct_answer' => '25 W'
            ],
            [
                'question' => 'How much work is done in moving a charge of 5 C across two points having a potential difference of 16 V?',
                'options' => json_encode([
                    '65 J',
                    '45 J',
                    '40 J',
                    '80 J'
                ]),
                'correct_answer' => '80 J'
            ],
            [
                'question' => 'An object is falling freely from a height x. After it has fallen to a height x/2 , it will possess.',
                'options' => json_encode([
                    'only potential energy',
                    'half potential and half kinetic energy',
                    'less potential and more kinetic energy',
                    'None of the above'
                ]),
                'correct_answer' => 'half potential and half kinetic energy'
            ],
            [
                'question' => 'What will be the energy possessed by a stationary object of mass 10 kg placed at a height of 20 m above the ground? (take g = 10 m/s)',
                'options' => json_encode([
                    '2 J',
                    '20 kJ',
                    '200 J',
                    '2 kJ'
                ]),
                'correct_answer' => '2 kJ'
            ],
        ];

        $chemistryQuestions = [
            [
                'question' => 'Which chemical is used for ripening of fruits?',
                'options' => json_encode([
                    'Methane',
                    'Ethylene',
                    'Sulphuric acid',
                    'More than one of the above'
                ]),
                'correct_answer' => 'Ethylene'
            ],
            [
                'question' => 'Washing soda is',
                'options' => json_encode([
                    'Sodium bicarbonate',
                    'Calcium carbonate',
                    'Hydrated sodium carbonate',
                    'None of the above'
                ]),
                'correct_answer' => 'Hydrated sodium carbonate'
            ],
            [
                'question' => 'Chemical name of washing soda is:',
                'options' => json_encode([
                    'Sodium chloride',
                    'Sodium hydrogen carbonate',
                    'Sodium carbonate',
                    'Sodium hydroxide'
                ]),
                'correct_answer' => 'Sodium carbonate'
            ],
            [
                'question' => 'Which acid is present in sour milk?',
                'options' => json_encode([
                    'Citric Acid',
                    'Acetic Acid',
                    'Glycolic Acid',
                    'Lactic Acid'
                ]),
                'correct_answer' => 'Lactic Acid'
            ],
            [
                'question' => 'How many water molecules are present in one molecule of washing soda?',
                'options' => json_encode([
                    '8',
                    '5',
                    '7',
                    '10'
                ]),
                'correct_answer' => '10'
            ]
        ];

        foreach ($physicsQuestions as $question) {
            Question::create([
                'subject' => 'physics',
                'question' => $question['question'],
                'options' => $question['options'],
                'correct_answer' => $question['correct_answer'],
            ]);
        }

        foreach ($chemistryQuestions as $question) {
            Question::create([
                'subject' => 'chemistry',
                'question' => $question['question'],
                'options' => $question['options'],
                'correct_answer' => $question['correct_answer'],
            ]);
        }
    }
}
