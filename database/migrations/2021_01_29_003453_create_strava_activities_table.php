<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStravaActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strava_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->string('name')->nullable();
            $table->float('distance')->default(0.0);
            $table->float('elevation_gain')->default(0.0);
            $table->integer('moving_time')->default(0);
            $table->integer('elapsed_time')->default(0);
            $table->string('type')->default('Other');
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
        Schema::dropIfExists('strava_activities');
    }
}
