<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuestionnaireController extends Controller
{
    /**
     * Generate a new questionnaire with random questions from physics and chemistry.
     *
     * This method validates the incoming request, creates a new questionnaire with the provided
     * title and expiry date, randomly selects 5 physics and 5 chemistry questions, attaches them
     * to the questionnaire, and returns the questionnaire details in a JSON response.
     * If an error occurs during this process, an error message is returned in the JSON response.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the questionnaire details.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the generated questionnaire details or an error message.
    */
    public function generate(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'expiry_date' => 'required|date',
            ]);

            $questionnaire = Questionnaire::create([
                'title' => $request->title,
                'expiry_date' => $request->expiry_date,
            ]);

            $physicsQuestions = Question::where('subject', 'physics')->inRandomOrder()->limit(5)->get();
            $chemistryQuestions = Question::where('subject', 'chemistry')->inRandomOrder()->limit(5)->get();

            $questionnaire->questions()->attach($physicsQuestions->merge($chemistryQuestions));

            return response()->json([
                'message' => 'Questionnaire generated successfully',
                'questionnaire' => $questionnaire,
                'questions' => $questionnaire->questions,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while generating the questionnaire.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retrieve a list of active questionnaires that have not expired.
     *
     * This method queries the database for questionnaires whose expiry date is greater
     * than or equal to the current date and time. If an error occurs during this process,
     * an error message is returned in the JSON response.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of active questionnaires or an error message.
    */
    public function active(): JsonResponse
    {
        try {
            $activeQuestionnaires = Questionnaire::where('expiry_date', '>=', now())->get();

            return response()->json($activeQuestionnaires);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving active questionnaires.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send email invitations to all students for a given questionnaire.
     *
     * This method retrieves all students from the database and sends an email invitation
     * to each student. The email contains a unique URL that the student can use to access
     * the questionnaire. If an error occurs during the email sending process, an error
     * message is returned in the JSON response.
     *
     * @param Questionnaire $questionnaire The questionnaire for which invitations are being sent.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success or failure of the operation.
    */
    public function sendInvitations(Questionnaire $questionnaire): JsonResponse
    {
        $students = Student::all();
        try {
            foreach ($students as $student) {
                $uniqueUrl = "http://localhost:5173/questionnaire/{$questionnaire->id}/student/{$student->id}";
                Mail::to($student->email)->send(new \App\Mail\QuestionnaireInvitation($questionnaire, $uniqueUrl, $student));
            }

            return response()->json([
                'message' => 'Invitations sent successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while sending invitations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the list of questions to a student for a specific questionnaire.
     *
     * This method checks if the questionnaire has expired. If the questionnaire is active,
     * it retrieves the associated questions and returns them along with the questionnaire
     * and student details in a JSON response. If an error occurs during this process,
     * an error message is returned in the JSON response.
     *
     * @param Questionnaire $questionnaire The questionnaire to be shown.
     * @param Student $student The student who is viewing the questionnaire.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the questionnaire, student, and questions data, or an error message.
    */
    public function show(Questionnaire $questionnaire, Student $student): JsonResponse
    {
        try {
            if ($questionnaire->expiry_date < now()) {
                return response()->json([
                    'message' => 'This questionnaire has expired.'
                ], 403);
            }

            $questions = $questionnaire->questions()->get();

            return response()->json([
                'questionnaire' => $questionnaire,
                'student' => $student,
                'questions' => $questions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the questionnaire details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
