<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Añadir nuevas columnas
            $table->bigInteger('COD_PERSONAS')->nullable()->unsigned()->comment('Codigo de persona')->after('id');
            $table->bigInteger('COD_ROL')->nullable()->unsigned()->comment('Codigo de Rol asignado')->after('COD_PERSONAS');
            $table->enum('IND_USER', ['1', '0'])->default('1')->comment('Estado del Uusuario')->after('password');
            $table->string('USR_ADD')->nullable()->comment('Usuario que lo creó')->after('USR_ADD');

            // Añadir llaves foráneas
            $table->foreign('COD_ROL')->references('COD_ROL')->on('roles')->onDelete('cascade');
            $table->foreign('COD_PERSONAS')->references('COD_PERSONAS')->on('personas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar llaves foráneas
            $table->dropForeign(['COD_ROL']);
            $table->dropForeign(['COD_PERSONAS']);

            // Eliminar columnas
            $table->dropColumn(['COD_PERSONAS', 'COD_ROL', 'IND_USER', 'USR_ADD']);
        });
    }
}

