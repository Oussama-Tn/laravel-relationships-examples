<?php

namespace App\Http\Controllers;

use Parsedown;

class MarkdownController extends Controller
{
    public function __invoke($md = false)
    {
        $filePath = $md
            ? base_path('md/' . $md . '.md')
            : base_path('README.md');

        $fileContent = app('files')->get($filePath);

        $fileContent = $this->fixImagesUrl($fileContent);

        $parsedownContent = (new Parsedown())->text($fileContent);

        return view('markdown.index', compact('parsedownContent'));
    }

    private function fixImagesUrl(string $text): string
    {
        return str_replace(
            '](public/images/',
            '](' . asset('/images') . '/',
            $text);
    }
}
