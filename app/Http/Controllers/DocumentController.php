<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    //
    public function store(Request $request)
    {
        $document = Document::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $document->addMedia($file)->toMediaCollection('files');
            }
        }

        // Redirect or return response
    }
}
