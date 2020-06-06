<?php

namespace App\Services;

use League\Flysystem\FileNotFoundException;
use Parsedown;

class MarkdownParser
{
    public function parseFile($path)
    {
        $filePath = base_path($path);

        $fileContent = app('files')->get($filePath);

        return (new Parsedown())->text($fileContent);
    }
}
