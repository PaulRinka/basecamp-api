<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;
use Basecamp;

class GoogleSocialiteController extends Controller
{


    public function redirectToGoogle()
    {
       
            return Socialite::driver('37signals')->redirect();
    }

public function handleCallback()
    {

            $user = Socialite::driver('37signals')->stateless()->user();
            // dd($user);
            // 22755266
                    Basecamp::init([
                    'id' => $user->user['accounts'][0]['id'],
                    'href' => $user->user['accounts'][0]['href'],
                    'token' => $user->token,
                    'refresh_token' => $user->refreshToken,
                    ]);

            // get projects     
            $projects = Basecamp::projects();

            // dd($projects->index());
            
            // get todos
            $id='21970359';
            $project = Basecamp::projects()->show($id);
            $todo=$project->todoset();
            // get list of todos
            $todolist= $todo->todoLists()->index();
            dd($todolist);




    }
}
