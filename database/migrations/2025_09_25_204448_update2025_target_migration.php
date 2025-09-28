<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['individuel', 'groupe', 'institution'])->default('individuel');
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->string('profession')->nullable();
            $table->enum('secteur', ['education', 'sante', 'entreprise', 'public', 'associatif', 'agriculture'])->nullable();
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('targets');
    }
};
