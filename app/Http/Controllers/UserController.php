<?php
namespace App\Http\Controllers;
use App\Models\UserFile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('userFiles')->get()->toArray();
        return array_reverse($users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'phone_number' => ['required', 'string'],
           'address' => ['required', 'string'],
           'zip_code' => ['required', 'string'],
        ]);
        $validatedData['data_path'] = Str::random(10);
        User::create($validatedData);

        return response()->json('User created!');
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());

        return response()->json('User updated!');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json('User deleted!');
    }

    public function upload($id, Request $request){
        if($request->file('files')){
            $user = User::find($id);
            $files = $request->file('files');
            $fileName = Storage::putFile($user->data_path, $files);
            $userFile = new UserFile([
                'filename' =>  $fileName
            ]);
            $user->userFiles()->save($userFile);
            return response()->json('Upload Succesful!');
        }
    }
}