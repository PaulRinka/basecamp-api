<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public $table = "modules";

    protected $fillable = ['module_name','status']; 
}
