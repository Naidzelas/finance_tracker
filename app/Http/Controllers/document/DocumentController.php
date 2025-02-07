<?php

namespace App\Http\Controllers\document;

use App\Http\Controllers\Controller;
use App\Models\Documents\Document;

class DocumentController extends Controller
{
    // TODO possibly add trait for mime sorting and return correct class instance
    public function download($filename)
    {
        $file = new PDF($filename);
        return $file->download();
    }
    public function open($filename)
    {
        $file = new PDF($filename);
        return $file->open();
    }
    public function destroy($documentId)
    {
        $document = Document::find($documentId);
        $file = new PDF($document->filename);
        if ($file->exists()) {
            $file->delete();
            $document->delete();
        }
    }
}
