<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('game_date');

            $table->dateTime('start_datetime')->after('away_team_id');
            $table->dateTime('end_datetime')->after('start_datetime');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['start_datetime', 'end_datetime']);
            $table->dateTime('game_date')->after('away_team_id');
        });
    }
};
