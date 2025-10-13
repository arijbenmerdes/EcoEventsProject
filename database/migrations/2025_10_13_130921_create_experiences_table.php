<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->nullable();
            $table->text('strengths')->nullable();
            $table->text('improvements')->nullable();
            $table->text('testimonial')->nullable();
            $table->text('lessons')->nullable();
            $table->text('recommendation')->nullable();
            $table->decimal('hours_contributed', 5, 2)->nullable();
            $table->integer('people_reached')->nullable();
            $table->decimal('waste_collected', 6, 2)->nullable();
            $table->integer('trees_planted')->nullable();
            $table->text('personal_impact')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('experiences');
    }
};
