<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponseController extends Controller
{

    /**
     * Store responses for a questionnaire.
     *
     * This method validates the incoming request, then iterates through the provided answers
     * and stores each response in the database. If an error occurs during this process,
     * an error message is returned in the JSON response.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the student ID, questionnaire ID, and answers.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success or failure of the operation.
    */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'questionnaire_id' => 'required|exists:questionnaires,id',
                'answers' => 'required|array',
                'answers.*' => 'required|string',
            ]);

            foreach ($request->answers as $question_id => $answer) {
                Response::create([
                    'student_id' => $request->student_id,
                    'questionnaire_id' => $request->questionnaire_id,
                    'question_id' => $question_id,
                    'answer' => $answer,
                ]);
            }
            return response()->json(['message' => 'Responses submitted successfully'], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while submitting responses.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}

