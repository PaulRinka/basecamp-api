<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoSet extends Model
{
    public $table = "todo_sets";

    protected $fillable = ['visible_to_clients','title','project_id', 'status', 'todo_created_at', 'todo_updated_at', 'inherits_status', 'type',
    'url','app_url','bookmark_url','subscription_url','comments_count','comments_url','position','description','creator',
    'completed','completed_ratio','name','todos_url','groups_url','app_todos_url','created_at','updated_at'
];
}
