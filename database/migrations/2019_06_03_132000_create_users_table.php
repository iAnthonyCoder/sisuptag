<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('password');
            $table->string('last_login_ip')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_active')->default(0);
            $table->boolean('enabled')->default(1);
            $table->unsignedInteger('modulos_id_u')->nullable();
            $table->foreign('modulos_id_u')
            ->references('id')->on('modulos')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
