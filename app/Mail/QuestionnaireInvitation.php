<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuestionnaireInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $questionnaire;
    public $url;
    public $student;


    public function __construct($questionnaire, $url, $student)
    {
        $this->questionnaire = $questionnaire;
        $this->url = $url;
        $this->student = $student;
    }

    public function build()
    {
        return $this->view('emails.questionnaire_invitation')
            ->with([
                'questionnaireTitle' => $this->questionnaire->title,
                'url' => $this->url,
                'studentName' => $this->student->name,
            ]);
    }
}
