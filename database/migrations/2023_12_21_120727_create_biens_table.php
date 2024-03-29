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
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->double('prix');
            $table->integer('nombre_chambres');
            $table->double('surface');
            $table->string('ville');
            $table->string('adresse');
            $table->string('code_postal');
            $table->string('imagebien');
            $table->string('type');

            $table->unsignedBigInteger('scategorieID');
            $table->foreign('scategorieID')
                ->references('id')
                ->on('sous_categorie_biens')
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
        Schema::dropIfExists('biens');
    }
};
