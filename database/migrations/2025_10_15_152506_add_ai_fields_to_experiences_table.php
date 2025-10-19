<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('experiences', function (Blueprint $table) {
            // 🧠 Champs IA : Résumé et sentiment générés automatiquement
            $table->text('ai_summary')->nullable()->after('image_url');
            $table->string('ai_sentiment')->nullable()->after('ai_summary');
        });
    }

   
    public function down()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(['ai_summary', 'ai_sentiment']);
        });
    }
};
