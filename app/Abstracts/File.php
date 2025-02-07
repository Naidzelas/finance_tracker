<?php

namespace App\Abstracts;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class File
{
    public $location;
    public $file;
    public $content;

    public function __construct($file, $content = '', $location = 'local')
    {
        $this->location = $location;
        $this->file = $file;
        $this->content = $content;
    }
    public function download()
    {
        return Storage::download($this->file);
    }
    public function upload()
    {
        Storage::disk($this->location)->put($this->file, $this->content);
    }
    public function delete()
    {
        Storage::delete($this->file);
    }

    public function open()
    {
        $path = Storage::disk($this->location)->path($this->file);
        return response()->file($path);
    }
    public function exists()
    {
        return Storage::disk($this->location)->exists($this->file);
    }
}
