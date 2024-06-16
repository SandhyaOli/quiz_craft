<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Questionnaire;
use App\Models\Student;
use App\Models\User;

class QuestionnaireControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create(['is_admin' => true]);
    }

    public function test_generate_questionnaire()
    {
        $this->actingAs(User::first());
        $data = [
            'title' => 'Sample Questionnaire',
            'expiry_date' => now()->addDays(7)->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/questionnaires/generate', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'questionnaire' => [
                         'id',
                         'title',
                         'expiry_date',
                     ],
                     'questions',
                 ]);

        $this->assertDatabaseHas('questionnaires', [
            'title' => 'Sample Questionnaire',
        ]);
    }

    public function test_active_questionnaires()    
    {
        // Create an active questionnaire (expiry date in the future)
        Questionnaire::factory()->create([
            'expiry_date' => now()->addDays(7)->format('Y-m-d')
        ]);

        // Create an inactive questionnaire (expiry date in the past)
        Questionnaire::factory()->create([
            'expiry_date' => now()->subDays(7)->format('Y-m-d')
        ]);

        // Retrieve active questionnaires via API endpoint
        $response = $this->getJson('/api/questionnaires/active');

        // Assert HTTP status code and JSON structure
        $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => [
                        'id',
                        'title',
                        'expiry_date',
                    ],
                ]);

        // Additional assertions for the specific content of returned JSON
        $response->assertJsonFragment([
            'expiry_date' => now()->addDays(7)->format('Y-m-d')
        ]);
    }

    public function test_show_questionnaire()
    {
        $questionnaire = Questionnaire::factory()->create();
        $student = Student::factory()->create();

        $response = $this->getJson("/api/questionnaires/{$questionnaire->id}/student/{$student->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'questionnaire' => [
                         'id',
                         'title',
                         'expiry_date',
                     ],
                     'student' => [
                         'id',
                         'name',
                         'email',
                     ],
                     'questions' => [
                         '*' => [
                             'id',
                             'question',
                             'options',
                         ],
                     ],
                 ]);
    }
}

