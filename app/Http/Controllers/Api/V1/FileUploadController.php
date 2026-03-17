<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // 1. Determine if it's a private document or a public pastry photo
            // We can check the path/folder logic here
            $folder = $file->getClientOriginalExtension() === 'pdf' ? 'documents' : 'pastries';
            
            // 2. Generate a clean name
            $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // 3. Store in Backblaze
            $path = $file->storeAs($folder, $fileName, 's3');

            // 4. Generate a Temporary Signed URL
            // Pastry photos for landing page: 1 week (maximum allowed by most S3 providers)
            // PDF documents: 30 minutes
            $expiry = $folder === 'pastries' ? now()->addDays(7) : now()->addMinutes(30);
            $url = Storage::disk('s3')->temporaryUrl($path, $expiry);

            return response()->json([
                'message' => 'Uploaded successfully',
                'path' => $path, // Save this $path in your DB (e.g., members.proof_of_payment)
                'url' => $url
            ]);
        }
    }
}