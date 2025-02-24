<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Form Submission</title>
</head>
<body>
    <div>
        <h1>Thanks for your contact! We will reach out to you after reviewing your message.</h1>
        <p>Hello, {{ $name }}</p> 
        <p>Your Message: {!! nl2br(e($usermessage)) !!}</p> 
    </div>
</body>
</html>
