<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStravaConnectionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strava_connection_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                \App\Models\StravaConnectionLog::SUCCESS,
                \App\Models\StravaConnectionLog::DEBUG,
                \App\Models\StravaConnectionLog::ERROR,
                \App\Models\StravaConnectionLog::INFO,
                \App\Models\StravaConnectionLog::WARNING
            ]);
            $table->text('log')->nullable();
            $table->unsignedBigInteger('team_id');
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
        Schema::dropIfExists('strava_connection_logs');
    }
}
