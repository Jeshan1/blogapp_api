<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; }
        .content { margin-top: 10px; }
        .blog-image { width: 100%; max-width: 400px; height: auto; }
    </style>
</head>
<body>
    <h1>{{ $blog->title }}</h1>
    <p><strong>Published on:</strong> {{ $blog->created_at->format('M d, Y') }}</p>

    @if($imageUrl)
        <img src="{{ $imageUrl }}" class="blog-image">
    @else
        <p>No image available</p>
    @endif

    <div class="content">
        {!! nl2br(e($blog->description)) !!}
    </div>

    <p><strong>Categories:</strong>
        @foreach ($blog->categories as $category)
            {{ $category->cat_name }},
        @endforeach
    </p>
</body>
</html>
