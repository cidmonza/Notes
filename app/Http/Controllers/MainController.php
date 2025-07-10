<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\TryCatch;

class MainController extends Controller
{
    public function index()
    {
        // load user's notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        //show home view
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request){
        echo 'nova nota está sendo criada';
    }

    public function editNote($id)
    {
        $validId = Operations::decryptId($id);
        if(!$validId){
            redirect()->route('home')->withErrors("O id da nota é inválida.");
        }else{
            echo "editing note with id = $id";
        }
        
    }

    public function deleteNote($id)
    {
        $validId = Operations::decryptId($id);
        if(!$validId){
            redirect()->route('home')->withErrors("Erro na tentativa de deletar nota.");
        }
        echo "deleting note with id = $id";
    }
}
