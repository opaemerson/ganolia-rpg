<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profile_functionalities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                ->constrained('profiles')
                ->onDelete('cascade');

            $table->foreignId('functionality_id')
                ->constrained('functionalities')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['profile_id', 'functionality_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_functionalities');
    }
};
