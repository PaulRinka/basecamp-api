<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todos extends Model
{
    public $table = "todos";

    protected $fillable = ['todo_set_id','todo_unique_id',	'visible_to_clients','title','status','todo_created_at','todo_updated_at','inherits_status','type',
	'url',	'app_url',	'bookmark_url','assignees','creator',
	'subscription_url',	'comments_count','comments_url','position','description','completed','content','start_on','due_on'
];
}



?>