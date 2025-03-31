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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained('users')->onDelete('cascade');
            $table->string('address');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('number_of_rooms');
            $table->enum('house_type', ['apartment', 'house', 'studio', 'duplex', 'flat']);
            $table->enum('status', ['available', 'rented'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
