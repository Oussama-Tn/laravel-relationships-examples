<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Parsedown;

class MarkdownController extends Controller
{
    public function __invoke($md = false)
    {
        $filePath = $md
            ? base_path('md/' . $md . '.md')
            : base_path('README.md');

        if(! file_exists($filePath)) {
            abort(404);
        }

        $fileContent = app('files')->get($filePath);

        $fileContent = $this->fixUrls($fileContent);

        $parsedownContent = (new Parsedown())->text($fileContent);

        return view('markdown.index', compact('parsedownContent'));
    }

    private function fixUrls(string $text): string
    {
        // find strings that start with "(md/" and ends with ".md)":
        // this will be used to generate links to md files: http://website.test/path-to-md-file
        preg_match_all("/\(md\/.+.md\)/", $text, $matches);

        foreach ($matches[0] as $match) {
            //if (Str::startsWith($match, '(md/') && Str::endsWith($match, '.md)')) {
                $text = str_replace(['(md/', '.md)'], ['(', ')'], $text);
            //}
        }

        return str_replace(
            '](public/images/',
            '](' . asset('/images') . '/',
            $text);
    }
}
