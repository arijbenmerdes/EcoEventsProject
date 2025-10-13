<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('campaign_target', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('target_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['campaign_id', 'target_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaign_target');
    }
};
