<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSolicitacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitacoes', function (Blueprint $table) {
            $table->string('rg');
            $table->string('telefone');
            $table->string('carteirinha');
            $table->string('cpf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitacoes', function (Blueprint $table) {
            $table->dropColumn('cpf');
            $table->dropColumn('carteirinha');
            $table->dropColumn('telefone');
            $table->dropColumn('rg');
        });
    }
}
