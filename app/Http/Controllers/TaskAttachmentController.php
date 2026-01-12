<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskAttachmentController extends Controller
{
    public function download(Task $task, $index)
    {
        $attachments = $task->attachments;

        if (!isset($attachments[$index])) {
            abort(404, 'Fichier introuvable.');
        }

        $file = $attachments[$index];
        $filePath = storage_path('app/public/' . $file['path']);

        if (!file_exists($filePath)) {
            abort(404, 'Le fichier n\'existe plus sur le serveur.');
        }

        return response()->download($filePath, $file['name']);
    }
}
