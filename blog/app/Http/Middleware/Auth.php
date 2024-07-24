<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        //Получаем данные пользователя из сессии
        $userName = $request->session()->get('userName');
        $userEmail = $request->session()->get('userEmail');
        $userToken = $request->session()->get('userToken');

        //проверяем данные на заполненость
        if (is_null($userName) || is_null($userEmail) || is_null($userToken))
        {
            if ($request->ajax())
            {
                return response('Чтобы продолжить действие, авторизуйтесь', 401);
            }

            $request->session()->flush();

            $request->session()->flash('error', 'чтобы перейти дальше, войдите в аккаунт');
            return redirect('/user/auth');
        }

        $user = User::where([
            'name' => $userName,
            'email' => $userEmail,
            'token' => $userToken
        ])->first();

        //проверяем данные на достоверность
        if (is_null($user))
        {
            if ($request->ajax())
            {
                return response('сиситема не может индентифицировать вас', 401);
            }

            $request->session()->flush();

            $request->session()->flash('error', 'сиситема не может индентифицировать вас');

            return redirect('/user/auth');
        }

        return $next($request);
    }
}
