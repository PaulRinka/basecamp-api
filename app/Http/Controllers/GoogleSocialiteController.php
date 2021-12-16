<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;
use DB;
use App\Project;
use App\TodoSet;
use App\Comment;
use App\Todos;
use App\Module;
use GuzzleHttp\Client;
use Basecamp;
use Helpers;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class GoogleSocialiteController extends Controller
{

        Protected $basecamp ;

public function __construct()
{
        $this->basecamp =  new Basecamp;
}

public function redirectToGoogle()
{

        return Socialite::driver('37signals')->redirect();
}



   public function handleCallback()
   {

        $orderProductsData=array();
        $user = Socialite::driver('37signals')->stateless()->user();
//   dd($user);
        Session::put(['token' => $user->token,'refresh_token' => $user->refreshToken]);
        $token = Session::get('token');
        $refresh_token = Session::get('refresh_token');

        if(!User::where('user_uniqe_id',$user->id)->exists())
        {
                $userDetail = new User;
                $userDetail->fname = $user->name;
                $userDetail->email =$user->email;
                $userDetail->user_uniqe_id = $user->id;
                $userDetail->token =$user->token;
                $userDetail->refresh_token =$user->refreshToken;

                $userDetail->save();
        }
    
        $b =  $this->basecamp::init([
        'id' => $user->user['accounts'][0]['id'],
        'href' => $user->user['accounts'][0]['href'],
        'token' => $user->token,
        'refresh_token' => $user->refreshToken,
        ]);


        //Extract basecamp produtId        
        $allProjects= $b->projects()->index(); 
        $rows = [];
        foreach($allProjects as $key => $allProject) 
        {
                array_push($rows, $allProject->id);
        }
        // Extract database Project Id
        $projectDetail=$project=Project::pluck('project_id')->toArray(); 
        //  find which database does not exists in projects table 
        $exitsProjectId = array_diff($rows, $projectDetail); 
        // insert multiple  data in project   
        $success = false; //flag
        DB::beginTransaction();
        // try{
                foreach($allProjects as $allProject) 
                {
                        if(in_array($allProject->id, $exitsProjectId))
                        { 
                          //insert data in projects       
                          $product =  new Project(); 
                                $orderProductsData[] =[
                                'project_id' => $allProject->id,
                                'poject_created_at' => $allProject->created_at,
                                'project_updated_at' => $allProject->updated_at,
                                'name' => $allProject->name,
                                'description' => $allProject->description,
                                'purpose' => $allProject->purpose,
                                'client_enable' => $allProject->clients_enabled,
                                'bookmark_url' => $allProject->bookmark_url,
                                'url' => $allProject->url,
                                'app_url' => $allProject->app_url,           
                                ];
                        }

                        $id='21970359';
                        // $project = Basecamp::projects()->show($allProject->id);
                        $project = Basecamp::projects()->show($id);
                        $todo=$project->todoset();
                        $todoSets= $todo->todoLists()->index();
                        $todoSets=$todoSets->toArray();
                        // insert todo-set
                
                }
            
                Project::insert($orderProductsData);
                        // $success = true;
                        // if ($success) 
                        // {
                        //     DB::commit();     
                        // }
                      
        // }
        // catch (\Exception $e) {
        //         DB::rollback();
        //         $success = false;
        //         return ["error" => $e->getMessage()];
        // }
                       
                                // $projects = Basecamp::projects();
                               
                                // $id='21970359';
                                // $project = Basecamp::projects()->show($id);
                                // $todo=$project->todoset();
                                // // dd($todo);
                                // // get list of todos
                                // $todoId='3695689391';
                                // $todolist= $todo->todoLists()->show($todoId);

                                // //  get todos all todo
                                // $todoListGroups = $todolist->todos()->index();
                                // // dd($allProjects,$todolist,$todoListGroups);
                                // // return $this->todolist();
                        return view('basecamp/index')->with(['user'=> $user,'allProjects'=>$allProjects]);

         }


 
              
                public function get(Request $request)
                {  
                        return view('basecamp/todolist');
                } 


                public function todolist(Request $request)
                {  

                        $client = new Client;

                        $response = $client->get($request->url, [
                            'headers' => [
                                'Authorization' => 'Bearer BAhbB0kiAbB7ImNsaWVudF9pZCI6ImU0ODAxZmEyMWRhYTA4Y2NjNjU1Y2YxM2M2Zjg3OWFiYjBmNDNmYmIiLCJleHBpcmVzX2F0IjoiMjAyMS0xMi0zMFQwNDoyNToyOFoiLCJ1c2VyX2lkcyI6WzQ0NTUzMzU1XSwidmVyc2lvbiI6MSwiYXBpX2RlYWRib2x0IjoiNDM5MzcwZGUxODIxMWQxOWEzOTE0MDkwN2ZjNTE3NjIifQY6BkVUSXU6CVRpbWUNxG8ewGhDyGUJOg1uYW5vX251bWkCjQI6DW5hbm9fZGVuaQY6DXN1Ym1pY3JvIgdlMDoJem9uZUkiCFVUQwY7AEY=--78d5104680ce1b6fd0e6a7745f4618cf1bcba4dc',
                            ]
                        ]);
                
                        $response = json_decode($response->getBody(), true);
                       
        
                $TODOSETS = $client->get($response['todolists_url'], [
                        'headers' => [
                            'Authorization' => 'Bearer BAhbB0kiAbB7ImNsaWVudF9pZCI6ImU0ODAxZmEyMWRhYTA4Y2NjNjU1Y2YxM2M2Zjg3OWFiYjBmNDNmYmIiLCJleHBpcmVzX2F0IjoiMjAyMS0xMi0zMFQwNDoyNToyOFoiLCJ1c2VyX2lkcyI6WzQ0NTUzMzU1XSwidmVyc2lvbiI6MSwiYXBpX2RlYWRib2x0IjoiNDM5MzcwZGUxODIxMWQxOWEzOTE0MDkwN2ZjNTE3NjIifQY6BkVUSXU6CVRpbWUNxG8ewGhDyGUJOg1uYW5vX251bWkCjQI6DW5hbm9fZGVuaQY6DXN1Ym1pY3JvIgdlMDoJem9uZUkiCFVUQwY7AEY=--78d5104680ce1b6fd0e6a7745f4618cf1bcba4dc',
                        ]
                    ]);
            
                    $todoSets = json_decode($TODOSETS->getBody(), true);
                //     dd($todoSets);
                    $rows = [];
                    foreach($todoSets as $key => $todoSet) 
                    {
                            array_push($rows, $todoSet['id']);
                    }

                    $todoSetsdata=$TodoSet=TodoSet::pluck('todo_set_unique_id')->toArray(); 
                    //  find which database does not exists in projects table 
                    $exitsTotoListId = array_diff($rows, $todoSetsdata); 

                        if (is_iterable($todoSets))
                        {
                                                foreach($todoSets as $todoSet) {
                                                        if(in_array($todoSet['id'], $exitsTotoListId))
                                        { 
                                                        $Todo = new TodoSet();
                                                        $Todo->todo_set_unique_id = $todoSet['id'];
                                                        $Todo->status = $todoSet['status'];
                                                        $Todo->visible_to_clients = $todoSet['visible_to_clients'];
                                                        $Todo->todo_created_at = $todoSet['created_at'];
                                                        $Todo->todo_updated_at = $todoSet['updated_at'];
                                                        $Todo->title = $todoSet['title'];
                                                        $Todo->inherits_status = $todoSet['inherits_status'];
                                                        $Todo->type = $todoSet['type'];
                                                        $Todo->url = $todoSet['url'];
                                                        $Todo->app_url = $todoSet['app_url'];
                                                        $Todo->bookmark_url = $todoSet['bookmark_url'];
                                                        $Todo->subscription_url = $todoSet['subscription_url'];
                                                        $Todo->comments_count = $todoSet['comments_count'];
                                                        $Todo->comments_url = $todoSet['comments_url'];
                                                        $Todo->position = $todoSet['position'];
                                                        $Todo->description = $todoSet['description'];
                                                        $Todo->completed = $todoSet['completed'];
                                                        $Todo->completed_ratio = $todoSet['completed_ratio'];
                                                        $Todo->name = $todoSet['name'];
                                                        $Todo->todos_url = $todoSet['todos_url'];
                                                        $Todo->groups_url = $todoSet['groups_url'];
                                                        $Todo->app_todos_url = $todoSet['app_todos_url'];
                                                        $Todo->created_at = Carbon::now();
                                                        $Todo->updated_at = Carbon::now();
                                                        $Todo->project_id = $request->projet_id;
                                                        $Todo->creator = $todoSet['creator']['name'];
                                                        
                                                        $Todo->save();
                                        }
                                                }
                                              
                         }
                         $todoSetsLists=TodoSet::where('project_id',$request->projet_id)->get();
                         return view('basecamp/todolist')->with(['todoSetsLists'=>$todoSetsLists]);
                      
       
                
                }



        public function todos(Request $request){
                $client = new Client;
                
                $response = $client->get($request->url, [
                        'headers' => [
                        'Authorization' => 'Bearer BAhbB0kiAbB7ImNsaWVudF9pZCI6ImU0ODAxZmEyMWRhYTA4Y2NjNjU1Y2YxM2M2Zjg3OWFiYjBmNDNmYmIiLCJleHBpcmVzX2F0IjoiMjAyMS0xMi0zMFQwNDoyNToyOFoiLCJ1c2VyX2lkcyI6WzQ0NTUzMzU1XSwidmVyc2lvbiI6MSwiYXBpX2RlYWRib2x0IjoiNDM5MzcwZGUxODIxMWQxOWEzOTE0MDkwN2ZjNTE3NjIifQY6BkVUSXU6CVRpbWUNxG8ewGhDyGUJOg1uYW5vX251bWkCjQI6DW5hbm9fZGVuaQY6DXN1Ym1pY3JvIgdlMDoJem9uZUkiCFVUQwY7AEY=--78d5104680ce1b6fd0e6a7745f4618cf1bcba4dc',
                        ]
                ]);

                $todos = json_decode($response->getBody(), true);  
                
        //        dd($todos,'abe');
                $rows = [];
                foreach($todos as $key => $todo) 
                {
                        array_push($rows, $todo['id']);
                }

                $todoSetsdata=$TodoSet=Todos::pluck('todo_unique_id')->toArray(); 
                //  find which database does not exists in projects table 
                $exitsTotoListId = array_diff($rows, $todoSetsdata); 

                
                                foreach($todos as $todo) {
                                        if(in_array($todo['id'], $exitsTotoListId))
                                        { 
                                        $Todo = new Todos();
                                        $Todo->todo_unique_id = $todo['id'];
                                        $Todo->status = $todo['status'];
                                        $Todo->visible_to_clients = $todo['visible_to_clients'];
                                        $Todo->todo_created_at = $todo['created_at'];
                                        $Todo->todo_updated_at = $todo['updated_at'];
                                        $Todo->title = $todo['title'];
                                        $Todo->inherits_status = $todo['inherits_status'];
                                        $Todo->type = $todo['type'];
                                        $Todo->url = $todo['url'];
                                        $Todo->app_url = $todo['app_url'];
                                        $Todo->bookmark_url = $todo['bookmark_url'];
                                        $Todo->subscription_url = $todo['subscription_url'];
                                        $Todo->comments_count = $todo['comments_count'];
                                        $Todo->comments_url = $todo['comments_url'];
                                        $Todo->position = $todo['position'];
                                        $Todo->description = $todo['description'];
                                        $Todo->completed = $todo['completed'];
                                        $Todo->content = $todo['content'];
                                        $Todo->start_on = $todo['starts_on'];
                                        
                                        $Todo->due_on = $todo['due_on'];
                                        $Todo->created_at = Carbon::now();
                                        $Todo->updated_at = Carbon::now();
                                        $Todo->todo_set_id = $request->todo_set_id;
                                        $Todo->creator = $todo['creator']['name'];
                                        // $Todo->assignees = $todo['assignees']['0']['name'];
                                        $Todo->save();
                                        }
                        }
                       $TodoSets =Todos::where('todo_set_id',$request->todo_set_id)->get();
                //        dd($TodoSets);
                        return view('basecamp/todos')->with(['TodoSets'=>$TodoSets]);

        }




        public function comment(Request $request){
       
                $client = new Client;
                
                $response = $client->get($request->url, [
                        'headers' => [
                        'Authorization' => 'Bearer BAhbB0kiAbB7ImNsaWVudF9pZCI6ImU0ODAxZmEyMWRhYTA4Y2NjNjU1Y2YxM2M2Zjg3OWFiYjBmNDNmYmIiLCJleHBpcmVzX2F0IjoiMjAyMS0xMi0zMFQwNDoyNToyOFoiLCJ1c2VyX2lkcyI6WzQ0NTUzMzU1XSwidmVyc2lvbiI6MSwiYXBpX2RlYWRib2x0IjoiNDM5MzcwZGUxODIxMWQxOWEzOTE0MDkwN2ZjNTE3NjIifQY6BkVUSXU6CVRpbWUNxG8ewGhDyGUJOg1uYW5vX251bWkCjQI6DW5hbm9fZGVuaQY6DXN1Ym1pY3JvIgdlMDoJem9uZUkiCFVUQwY7AEY=--78d5104680ce1b6fd0e6a7745f4618cf1bcba4dc',
                        ]
                ]);

                $comments = json_decode($response->getBody(), true);  

                $rows = [];
                foreach($comments as $key => $comment) 
                {
                        array_push($rows, $comment['id']);
                }

               $CommentSet=Comment::pluck('comment_unique_id')->toArray(); 
      
                //  find which database does not exists in projects table 
                $exitsTotoListId = array_diff($rows, $CommentSet); 
         
                                foreach($comments as $todo) {
                                        if(in_array($todo['id'], $exitsTotoListId))
                                        { 
                                        $Todo = new Comment();
                                        $Todo->comment_unique_id = $todo['id'];
                                        $Todo->visible_to_clients = $todo['visible_to_clients'];
                                        $Todo->comment_created_at = $todo['created_at'];
                                        $Todo->comment_updated_at = $todo['updated_at'];
                                        $Todo->title = $todo['title'];
                                        $Todo->inherits_status = $todo['inherits_status'];
                                        $Todo->type = $todo['type'];
                                        $Todo->url = $todo['url'];
                                        $Todo->app_url = $todo['app_url'];
                                        $Todo->bookmark_url = $todo['bookmark_url'];
                                        $Todo->content = $todo['content'];
                                        $Todo->creator = $todo['creator']['name'];
                                        $Todo->created_at = Carbon::now();
                                        $Todo->updated_at = Carbon::now();
                                        $Todo->todo_id = $request->todo_set_id;
                                        $Todo->save();
                                        }
                        }
                  

        
                      $Comments=Comment::where('todo_id',$request->todo_set_id)->get(); 
                      return view('basecamp/comments')->with(['Comments'=>$Comments]);
                  
        }

}





