<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('productName');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
