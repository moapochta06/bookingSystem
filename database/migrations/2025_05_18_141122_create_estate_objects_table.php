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
        Schema::create('estate_objects', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Заголовок
            $table->string('city'); // Город
            $table->string('street'); // Улица
            $table->string('house_number')->nullable(); // Дом №
            $table->string('apartment_number')->nullable(); // Квартира №
            $table->integer('rooms_count'); // Кол-во комнат
            $table->integer('guests_count'); // Кол-во гостей
            $table->integer('area'); // Площадь
            $table->integer('price'); // Цена 
            $table->text('description'); // Описание
            $table->string('image')->nullable(); // Путь к изображению
            $table->boolean('pets_allowed')->default(false); // Можно с животными
            $table->boolean('free_cleaning')->default(false); // Бесплатная уборка
            $table->boolean('air_conditioner')->default(false); // Кондиционер
            $table->boolean('wifi')->default(false); // Wi-Fi
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_objects');
    }
};
