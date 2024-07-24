<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Custom\TokenMaker;
use Exception;

class UserController extends Controller
{
    function auth(Request $request)
    {
        if($request->isMethod('post'))
        {
            $user = User::where([
                'email' => $request->email,
                'password' => $request->password
            ])->first();
            
            if ($user === null)
            {
                $request->session()->flash('error', 'такого пользователя не существует');
                return redirect('/user/auth');
            }

            session([
                'userId' => $user->id,
                'userName' => $user->name,
                'userEmail' => $user->email,
                'userToken' => $user->token
            ]);

            return redirect('/user/profile');
        }


        return view('user/auth');
    }


    function register(Request $request)
    { 
        if($request->isMethod('post'))
        {
            try
            {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'token' => TokenMaker::make()
                ]);
            }

            catch(\Illuminate\Database\QueryException $e)
            {
                // получаем сообщение об ошибке
                $error = $e->getMessage();

                //ошибка not null violation
                if(str_contains($error, 'SQLSTATE[23502]'))
                {
                    $request->session()->flash('error', 'пожалуйста, заполните все поля');
                    return redirect('/user/register');
                }

                //ошибка unique violation
                else if(str_contains($error, 'SQLSTATE[23505]'))
                {
                    $request->session()->flash('error', 'имя занято');
                    return redirect('/user/register');
                }

                $request->session()->flash('error', $e->getMessage());
                return redirect('/user/register');
            }

            catch(Exception $e)
            {
                //сделать перенаправление на 500
                $request->session()->flash('error', 'ошибка');
                return redirect('/user/register');
            }

            session([
                'userId' => $user->id,
                'userName' => $user->name,
                'userEmail' => $user->email,
                'userToken' => $user->token
            ]);
            
            return redirect('/user/profile');
        }


        return view('user/register');
    }


    function profile(Request $request)
    {
        $user = User::where([
            'name'=> $request->session()->get('userName'),
            'email' => $request->session()->get('userEmail'),
            'token' => $request->session()->get('userToken')
        ])->first();

        return view('user/profile', ['user' => $user]);
    }


    function exit(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

}
