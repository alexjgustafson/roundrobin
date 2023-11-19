<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('loser');
            $table->json('playerResults');
            $table->json('players');
            $table->string('result');
            $table->bigInteger('tournament_id');
            $table->bigInteger('winner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
