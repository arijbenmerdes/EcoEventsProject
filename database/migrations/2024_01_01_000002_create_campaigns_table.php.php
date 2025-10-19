<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('objective');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->enum('status', ['draft', 'active', 'paused', 'completed', 'cancelled'])->default('draft');
            $table->enum('type', ['awareness', 'action', 'fundraising', 'volunteering']);
            $table->enum('ecological_focus', ['climate', 'biodiversity', 'waste', 'water', 'energy']);
            $table->string('location');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
