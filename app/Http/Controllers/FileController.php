<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'fileable_type' => ['required'],
            'fileable_id' => ['required'],
            'file' => ['file'],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = str_replace(' ', '-', $file->getClientOriginalName());
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $n = 0;

            do {
                $n++;
                $newFileName = $fileName . ($n > 1 ? "($n)" : '') . '.' . $fileExtension;
                $fileExist = File::where('file', 'uploads/' . $newFileName)->first();
            } while ($fileExist);

            $filePath = $file->storeAs('uploads', $newFileName, 'public');
        }

        auth()->user()->files()->create([
                'fileable_type' => $data['fileable_type'],
                'fileable_id' => $data['fileable_id'],
                'file' => $filePath,
            ]);

        $endUrl = '/' . strtolower(class_basename($data['fileable_type'])) . '/' . $data['fileable_id'];

        return redirect($endUrl);
    }
}
