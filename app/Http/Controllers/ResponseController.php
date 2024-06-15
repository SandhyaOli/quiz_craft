<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    // Store reponses for questionnaire
    public function store(Request $request)
    {
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
    }
}

