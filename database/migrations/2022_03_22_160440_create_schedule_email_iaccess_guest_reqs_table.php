<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleEmailIaccessGuestReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_email_iaccess_guest_reqs', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('cc');
            $table->string('name')->nullable();
            $table->integer('guest_form_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('document')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('schedule_email_iaccess_guest_reqs');
    }
}
