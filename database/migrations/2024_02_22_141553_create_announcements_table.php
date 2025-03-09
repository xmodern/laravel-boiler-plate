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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('category_id');
            $table->text('title');
            $table->text('position');
            $table->string('degree');
           
            $table->unsignedInteger('open_position');
            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->foreign('type_id')->references('id')->on('announcement_types')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('announcement_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
