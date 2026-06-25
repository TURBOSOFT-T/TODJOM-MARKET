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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
        
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
           
            $table->string('image')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();

            $table->date('limit')->nullable();

            $table->string('telephone')->nullable();
         
            $table->time('heure')->nullable(); // Nouvelle colonne pour l'heure
            $table->string('location')->nullable(); // Ex: ville ou plateforme
            $table->enum('type', ['webinaire', 'presentiel'])->default('presentiel'); // présentiel ou webinaire
            $table->string('adresse')->nullable(); // Adresse physique ou lien
            $table->boolean('active')->default(false);
            $table->boolean('free')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
