<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();

            $table->date('date_debut');
            $table->date('date_fin');

            $table->enum('statut', ['en_attente','confirmee','annulee'])->default('en_attente');
            $table->text('note')->nullable();

            $table->timestamps();

            $table->index(['vehicle_id', 'date_debut', 'date_fin']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
