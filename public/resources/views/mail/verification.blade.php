<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail Verification</title>
</head>
<body>
    
<p>Hi {{ $name }},</p>
<p>Please click the following link to verify your email address:</p>
<p><a href="{{ $url }}">{{ $url }}</a></p>
<p>Regards, <br>{{ env('APP_NAME')}} Team.</br> Please do not reply to this email</p>


</body>
</html>