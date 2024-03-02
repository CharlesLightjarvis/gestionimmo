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
        Schema::create('sous_categorie_biens', function (Blueprint $table) {
            $table->id();
            $table->string("nomscategorie")->unique();
            $table->string("imagescategorie");
            $table->unsignedBigInteger('categorieID');
            $table->foreign('categorieID')
                ->references('id')
                ->on('categorie_biens')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_categorie_biens');
    }
};
