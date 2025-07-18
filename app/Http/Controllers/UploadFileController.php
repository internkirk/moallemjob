<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        return view('panel.shop.product.upload.index',compact('product'));
    }


    public function store(Request $request)
    {
        $file = $request->file('file');
        $chunkNumber = $request->input('dzchunkindex');
        $totalChunks = $request->input('dztotalchunkcount');
        $fileName = $request->input('dzuuid') . '.' . $file->getClientOriginalExtension();

        // Ensure the chunks directory exists
        $chunksDir = storage_path('app/chunks');
        if (!File::exists($chunksDir)) {
            File::makeDirectory($chunksDir, 0755, true);
        }

        Storage::disk('private')->deleteDirectory('product/'.$request->productId);

        // Store chunk
        $chunkPath = $chunksDir . '/' . $fileName . '.' . $chunkNumber;
        $file->move(dirname($chunkPath), basename($chunkPath));

        // Log the chunk path
        // Log::info('Stored chunk: ' . $chunkPath);

        // Check if all chunks have been uploaded
        $chunksUploaded = File::glob($chunksDir . '/' . $fileName . '.*');

        // Merge chunks if all chunks are uploaded
        if (count($chunksUploaded) == $totalChunks) {
            // Ensure the final directory exists
            // $finalDir =  Storage::disk('local')->makeDirectory('/videos/'.$request->productId);
            $finalDir = storage_path('app/private/product/'.$request->productId);
            if (!File::exists($finalDir)) {
 
                File::makeDirectory($finalDir, 0755, true);
            }


            $finalPath = $finalDir . '/' . $fileName;
            $finalFile = fopen($finalPath, 'ab');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkPath = $chunksDir . '/' . $fileName . '.' . $i;
                if (File::exists($chunkPath)) {
                    $chunkContent = file_get_contents($chunkPath);
                    fwrite($finalFile, $chunkContent);
                    unlink($chunkPath);
                } else {
                    // Log::error('Missing chunk: ' . $chunkPath);
                }
            }


            fclose($finalFile);

            $finalPath = explode('app',$finalPath);

            Product::findOrFail($request->productId)->update([
                'file' => '/storage'.$finalPath[1]
            ]);
        }


        return response()->json(['status' => 'Chunk uploaded successfully']);
    }
}
