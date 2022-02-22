<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->bigInteger('software_type_id')->unsigned();
            $table->string('version');
            $table->string('vendor')->nullable();
            $table->text('product_key')->nullable();
            $table->integer('seats')->unsigned();
            $table->string('license_name')->nullable();
            $table->string('license_email')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('software_type_id')->references('id')->on('software_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licenses');
    }
}
