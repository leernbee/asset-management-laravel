<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('machine_tag')->unique();
            $table->string('name');
            $table->bigInteger('machine_type_id')->nullable()->unsigned();
            $table->bigInteger('operating_system_id')->nullable()->unsigned();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial');
            $table->string('support_link')->nullable();
            $table->date('service_date')->nullable();
            $table->bigInteger('status_id')->nullable()->unsigned();
            $table->bigInteger('location_id')->nullable()->unsigned();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('machine_type_id')->references('id')->on('machine_types');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('operating_system_id')->references('id')->on('operating_systems');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machines');
    }
}
