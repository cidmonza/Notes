<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

//use Illuminate\Support\Facades\dd;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // Form validation
        $request->validate(
        // Rules    
        [
            'text-username' => 'required|email',
            'text-password' => 'required|min:6|max:16'
        ],
        // Parametros (msg de erro)
        [
            'text-username.required' => 'O email é obrigatório.',
            'text-username.email' => 'O username deve ser um email válido.',
            'text-password.required' => 'O password é obrigatório',
            'text-password.min' => 'O password deve conter no mínimo :min caracteres.',
            'text-password.max' => 'O password deve conter no máximo :max caracteres.'
        ]

        );

        // Get user input

        $username = $request->input('text-username');
        $password = $request->input('text-password');

        // Checkar se o usuário está no banco de dados

        try {
            $user = User::where('username', $username)
                       ->where('deleted_at', NULL)
                       ->first();

           // echo '<pre>';
           // print_r($user);

           if(!$user){
                return redirect()->back()->withInput()->with('loginError', 'Usuário ou password incorretos.');
           }

           // check if password is correct

           if(!password_verify($password, $user->password)){
                return redirect()->back()->withInput()->with('loginError', 'Usuário ou password incorretos.');
           }

           // update last login

           $user->last_login = date('Y-m-d H:i:s');
           $user->save();

           // login user

            session([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username
                ]
                ]);
                         // ou session('user.username')
            //echo 'Login de ' . session('user')['username'] . ' feito com sucesso!';
            return redirect()->to('/');

        } catch (\Throwable $th) {
            //throw $th;
        }


    }

    public function logout()
    {
        // logout from application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
