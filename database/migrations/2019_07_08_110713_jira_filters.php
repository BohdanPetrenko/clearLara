<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JiraFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jira_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('filter_id');
            $table->string('schedule');
            $table->text('query')->nullable();
            $table->unsignedInteger('max_total_items')->nullable();
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
        Schema::dropIfExists('jira_filters');
    }
}
