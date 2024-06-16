<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Questionnaire;
use App\Models\Student;

class QuestionnaireInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $questionnaire;
    public $url;
    public $student;

    /**
     * Create a new message instance.
     *
     * @param Questionnaire $questionnaire The questionnaire details.
     * @param string $url The unique URL for the questionnaire invitation.
     * @param Student $student The student who is receiving the invitation.
    */
    public function __construct(Questionnaire $questionnaire, string $url, Student $student)
    {
        $this->questionnaire = $questionnaire;
        $this->url = $url;
        $this->student = $student;
    }

    /**
     * Build the questionnaire invitation email.
     *
     * This method constructs the email view with the necessary data including the questionnaire title,
     * invitation URL, and student name. If an error occurs during this process, the error is logged
     * and an exception is thrown.
     *
     * @throws \Exception If an error occurs while building the email.
     */
    public function build()
    {
        try {
            return $this->view('emails.questionnaire_invitation')
                ->with([
                    'questionnaireTitle' => $this->questionnaire->title,
                    'url' => $this->url,
                    'studentName' => $this->student->name,
                ]);
        } catch (\Exception $e) {
            throw new \Exception('An error occurred while building the email.');
        }
    }
}
