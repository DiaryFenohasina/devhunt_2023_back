<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->string('contenu');
            $table->integer('votePositif')->nullable();
            $table->integer('voteNegatif')->nullable();
            $table->foreignId('users_id')->constrained("users");
            $table->foreignId('questions_id')->constrained("questions");
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
        Schema::dropIfExists('reponses');
    }
}
