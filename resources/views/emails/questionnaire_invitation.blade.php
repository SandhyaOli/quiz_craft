<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Questionnaire Invitation</title>
</head>
<body>
    <p>Dear {{ $studentName }},</p>
    <p>You have been invited to participate in the questionnaire titled "{{ $questionnaireTitle }}".</p>
    <p>Please click the link below to start:</p>
    <p><a href="{{ $url }}">Start Questionnaire</a></p>
</body>
</html>

