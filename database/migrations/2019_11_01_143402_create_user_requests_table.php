<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ticket_id')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['None', 'Low', 'Medium', 'High']);
            $table->unsignedBigInteger('requester_id');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->enum('work_status', ['Open', 'In Progress', 'On Hold', 'Complete'])->nullable();
            $table->timestamps();

            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('worker_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_requests');
    }
}
