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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->string('label');
            $table->string('name');
            $table->string('type');
            $table->string('placeholder')->nullable();
            $table->text('default_value')->nullable();
            $table->text('help_text')->nullable();
            $table->string('validation_rules')->nullable();
            $table->text('options')->nullable(); // برای select, radio, checkbox
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_required')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
