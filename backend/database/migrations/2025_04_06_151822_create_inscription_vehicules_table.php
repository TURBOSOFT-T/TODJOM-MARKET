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
        Schema::create('inscription_vehicules', function (Blueprint $table) {
            $table->id();

            
            $table->enum("statut", ['créé', 'attente', 'traitement', 'payée', 'planification', 'retournée'])->default('attente');

            $table->enum("mode", ["espèce", "paypal", "carte de credit"])->default("espèce");
            $table->enum("etat", ["attente", "confirmé", "annulé"])->default("attente");
       
              $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('telephone')->nullable()->default(null);
            $table->string('whatsapp')->nullable()->default(null);
            $table->string('addresse')->nullable()->default(null);

            $table->unsignedBigInteger('user_id')->nullable();
           $table->unsignedBigInteger('event_id')->nullable();

            $table->unsignedBigInteger('vehicule_id')->nullable();
            

            $table->integer('prix_aller')->nullable();
            $table->integer('prix_retour')->nullable();
            $table->integer('prix_aller_retour')->nullable();
            
              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscription_vehicules');
    }
};
