<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use App\User;
use App\Services\Operations;

class MainController extends Controller
{
    public function index()
    {
        // load user's notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        //show home view
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request){

        // validate note title and text
        $request->validate(
            [
                'text_title' => 'required|min:2|max:200',
                'text_note' => 'required|min:2|max:3000'
            ],
            [
                'text_title.required' => 'O título é obrigatório',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres',
                'text_title.max' => 'O título deve ter no máximo :max caracteres',

                'text_note.required' => 'A nota é obrigatória',
                'text_note.min' => 'A nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres'
            ]
        );

        // get user
        $id = session('user.id');

        // create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        // redirect to home page
        return redirect()->route('home');

    }

    public function editNote($id)
    {
        $validId = Operations::decryptId($id);
        if(!$validId){
            return redirect()->route('home')->withErrors("O id da nota é inválida.");
        }else{
            // load note
            $note = Note::find($validId);

            // show edit note view
            return view('edit_note', ['note' => $note]);
        }
    }

    public function editNoteSubmit(Request $request){
        // validate request
        $request->validate(
            [
                'text_title' => 'required|min:2|max:200',
                'text_note' => 'required|min:2|max:3000'
            ],
            [
                'text_title.required' => 'O título é obrigatório',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres',
                'text_title.max' => 'O título deve ter no máximo :max caracteres',

                'text_note.required' => 'A nota é obrigatória',
                'text_note.min' => 'A nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres'
            ]
        );

        // check if note_id exists
        if($request->note_id == null){
            return redirect()->route('home');
        }

        // decrypt note_id
        $id = Operations::decryptId($request->note_id);

        // load note
        $note = Note::find($id);

        // update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        // redirect to home
        return redirect()->route('home');
    }

    public function deleteNote($id)
    {
        $validId = Operations::decryptId($id);
        if(!$validId){
            // É importante sempre utilizar return antes do redirect, mesmo que funcione sem o "return", para que middlewares etc funcionem
            return redirect()->route('home')->withErrors("Erro na tentativa de deletar nota.");
        }

        // load note

        $note = Note::find($validId);

        // go to delete note confirm view

        return view('delete_note_confirm', ['note' => $note]);
    }

    public function deleteNoteConfirm($id){

        $validId = Operations::decryptId($id);
        if(!$validId){
            return redirect()->route('home')->withErrors("Erro na tentativa de deletar a nota");
        }

        $note = Note::find($validId);

        // Hard delete:
        //$note->delete();

        // Soft delete:

        $note->deleted_at = date('Y-m-d, H:i:s');
        $note->save();

        return redirect()->route('home');
    }
}
