<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('description');

            $table->string('dirlocal')->nullable();
            $table->integer('codigo')->nullable();
            $table->integer('views')->default(0);
            $table->enum('tipo',['ORDINARIA','EXTRAORDINARIA'])->nullable();
            $table->date('fecha')->nullable();
            $table->unsignedInteger('modulos_id');
            $table->unsignedInteger('user_id');
            $table->foreign('modulos_id')
                ->references('id')->on('modulos')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
        DB::statement("ALTER TABLE documentos ADD pdf MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
