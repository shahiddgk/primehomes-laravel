<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_no');
            $table->enum('unit_type', ['STUDIO','ONE BED ROOM','STUDIO PREMIERE']);
            $table->string('floor_area')->nullable();
            $table->enum('parking', ['Y','N']);
            $table->string('slot_no')->nullable();
            $table->string('parking_area')->nullable();
            $table->enum('unit_paid', ['Y','N']);
            $table->string('parking_location')->nullable();
            $table->string('project_id');
            $table->integer('owner_id');
            $table->string('water_meter_number')->nullable();
            $table->foreign('project_id')->references('building_id')->on('projects');
            $table->foreign('owner_id')->references('id')->on('owners');
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
        Schema::dropIfExists('units');
    }
}
