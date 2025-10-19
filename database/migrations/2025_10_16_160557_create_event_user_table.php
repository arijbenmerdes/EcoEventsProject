<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('event_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // lien vers users
        $table->foreignId('event_id')->constrained()->onDelete('cascade'); // lien vers events
        $table->boolean('participated')->default(false); // l'utilisateur a participé
        $table->boolean('liked')->default(false);       // l'utilisateur aime l'événement
        $table->timestamps(); // created_at et updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user');
    }
};
