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
        Schema::create('form_response_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_response_id')->constrained()->onDelete('cascade');
            $table->string('field_name'); // name="email"
            $table->text('field_value')->nullable(); // محتوای فیلد (متن، شماره، ... یا آدرس فایل)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_response_items');
    }
};
