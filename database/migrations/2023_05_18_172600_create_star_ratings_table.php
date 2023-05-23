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
        Schema::create('star_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product");
            $table->unsignedBigInteger("user");
            // $table->longText("review")->nullable();
            $table->integer("star_rating");
            $table->foreign('product')->references('id')->on('products')->onDelete('cascade');       
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('star_ratings');
    }
};
