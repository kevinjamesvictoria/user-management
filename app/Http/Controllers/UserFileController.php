<?php
namespace App\Http\Controllers;
use App\Models\UserFile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserFileController extends Controller
{
    public function download($id)
    {
        $userFile = UserFile::with('user')->find($id);
        $filePath = 'app/' . $userFile->user->data . $userFile->filename;
        return response()->download(storage_path($filePath), null, [], null);
    }
}