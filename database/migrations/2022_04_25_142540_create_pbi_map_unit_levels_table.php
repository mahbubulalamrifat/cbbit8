<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbiMapUnitLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbi_map_unit_levels', function (Blueprint $table) {
            $table->id();
            $table->string('ul_code')->nullable();
            $table->string('ul_name')->nullable();
            $table->string('department')->nullable();
            $table->string('operation')->nullable();
            $table->string('business_unit')->nullable();
            $table->string('business')->nullable();
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
        Schema::dropIfExists('pbi_map_unit_levels');
    }
}
