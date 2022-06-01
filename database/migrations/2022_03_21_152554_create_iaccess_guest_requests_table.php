<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIaccessGuestRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iaccess_guest_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('branch')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('office_mobile')->nullable();
            $table->string('personal_mobile')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('office_email')->nullable();
            $table->string('internet_id')->nullable();

            $table->string('guest_company')->nullable();
            $table->integer('no_of_guest')->nullable();
            $table->string('guest_job')->nullable();
            $table->integer('guest_duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('document')->nullable();
            $table->string('document2')->nullable();

            // agreed by manager
            $table->integer('manager_id')->nullable();
            $table->string('manager_token')->nullable();
            $table->dateTime('manager_approved')->nullable();

            // approved by bu head
            $table->integer('bu_id')->nullable();
            $table->string('bu_token')->nullable();
            $table->dateTime('bu_approved')->nullable();

            // received by cpb it
            $table->integer('verify_status')->nullable();
            $table->integer('verify_by')->nullable();
            $table->dateTime('verify_date')->nullable();
            $table->string('verify_remarks')->nullable();
            
            $table->integer('apply_by')->nullable();
            $table->dateTime('apply_date')->nullable();
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
        Schema::dropIfExists('iaccess_guest_requests');
    }
}
