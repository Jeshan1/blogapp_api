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
        <h1>Hello Viewer, New Blog uploaded !!</h1> 
        <p>Blog Title : {{ $title }}</p> 
        <p>Short Description : {!! Str::words($description, 15, '...') !!}</p> 
        <a href="{{ url('/blogs/'.$id) }}">Visit site to view by click here</a>
    </div>
</body>
</html>