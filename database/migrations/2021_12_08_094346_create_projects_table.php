<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_id',50)->comment('project unique id');
            $table->string('poject_created_at',30);
            $table->string('project_updated_at',30);
            $table->string('name',255);
            $table->string('description')->nullable();
            $table->string('purpose')->nullable();
            $table->string('client_enable')->nullable();
            $table->string('bookmark_url')->nullable();
            $table->string('url')->nullable();
            $table->string('app_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}





