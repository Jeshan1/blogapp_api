<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use function App\Helper\apiResponse;

class BlogPdfController extends Controller
{
    public function generateBlogPdf($id)
    {
        $blog = Blog::with('categories')->findOrFail($id);
        if (!$blog) {
            return apiResponse([],"Blog Not Found",404);
        }

         // Get the actual file path
        $imagePath = $blog->getFirstMediaPath('blogs');
        $imageUrl = null;

        if ($imagePath && file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $mimeType = mime_content_type($imagePath);
            $imageUrl = "data:$mimeType;base64,$imageData";
        }


        // Load the view and pass blog data along with image URL
        $pdf = Pdf::loadView('pdf.blog', compact('blog', 'imageUrl'));

        return $pdf->download("blog_{$blog->id}.pdf");

        
    }
}
