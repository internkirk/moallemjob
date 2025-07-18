<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    public function download($id, $filename)
    {
        $path = storage_path('app/private/product/'.$id.'/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);

        // return new StreamedResponse(function () use ($path) {
        //     $stream = fopen($path, 'r');
        //     while (!feof($stream)) {
        //         echo fread($stream, 1024);
        //         flush();
        //     }
        //     fclose($stream);
        // }, 200, [
        //     'Content-Type' => mime_content_type($path),
        //     'Content-Length' => filesize($path),
        // ]);
    }
}
