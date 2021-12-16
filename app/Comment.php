<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = "comments";

    protected $fillable = ['todo_id','comment_unique_id','visible_to_clients','comment_created_at','comment_updated_at','title','inherits_status	type',
	'url','app_url'	,'bookmark_url','content','creator'
];
}


	
?>