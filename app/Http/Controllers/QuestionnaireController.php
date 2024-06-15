<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuestionnaireController extends Controller
{
    public function generate(Request $request)
    {
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
    }

    public function active()
    {
        $activeQuestionnaires = Questionnaire::where('expiry_date', '>=', now())->get();
        return response()->json($activeQuestionnaires);
    }

    public function sendInvitations(Questionnaire $questionnaire)
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


    public function show(Questionnaire $questionnaire, Student $student)
    {
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
    }

}
