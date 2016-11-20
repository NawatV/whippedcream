<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('userId');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('idNumber');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('gender');
            $table->date('birthDate');
            $table->string('phoneNumber');
            $table->string('email');
            $table->string('address');
            $table->string('userType');
        });

        Schema::create('patient', function (Blueprint $table) {
            $table->integer('patientId')->unsigned();
            $table->char('bloodType',2)->nullable();
            $table->string('allergen');
            $table->string('hn')->nullable()->unique();
            $table->primary('patientId');
            $table->foreign('patientId')->references('userId')->on('user');
        });

        Schema::create('doctor', function (Blueprint $table) {
            $table->integer('doctorId')->unsigned();
            $table->integer('departmentId')->unsigned();
            $table->string('doctorNumber')->unique();
            $table->primary('doctorId');
            $table->foreign('doctorId')->references('userId')->on('user');
            $table->foreign('departmentId')->references('departmentId')->on('department');
        });

        Schema::create('nurse', function (Blueprint $table) {
            $table->integer('nurseId')->unsigned();
            $table->integer('departmentId')->unsigned();
            $table->string('nurseNumber')->unique();
            $table->primary('nurseId');
            $table->foreign('nurseId')->references('userId')->on('user');
            $table->foreign('departmentId')->references('departmentId')->on('department');
        });

        Schema::create('pharmacist', function (Blueprint $table) {
            $table->integer('pharmacistId')->unsigned();
            $table->string('pharmacistNumber')->unique();
            $table->primary('pharmacistId');
            $table->foreign('pharmacistId')->references('userId')->on('user');
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->integer('staffId')->unsigned();
            $table->string('staffNumber')->unique();
            $table->primary('staffId');
            $table->foreign('staffId')->references('userId')->on('user');
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->integer('adminId')->unsigned();
            $table->string('adminNumber')->unique();
            $table->primary('adminId');
            $table->foreign('adminId')->references('userId')->on('user');
        });

        Schema::create('department', function (Blueprint $table) {
            $table->increments('departmentId');
            $table->string('departmentName');
            $table->string('location');
        });

        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('scheduleId');
            $table->integer('doctorId')->unsigned();
            $table->char('sunPeriod',1);
            $table->char('monPeriod',1);
            $table->char('tuePeriod',1);
            $table->char('wedPeriod',1);
            $table->char('thuPeriod',1);
            $table->char('friPeriod',1);
            $table->char('satPeriod',1);
            $table->foreign('doctorId')->references('doctorId')->on('doctor');
        });

        Schema::create('appointment', function (Blueprint $table) {
            $table->increments('appointmentId');
            $table->integer('patientId')->unsigned();
            $table->integer('doctorId')->unsigned();
            $table->date('appDate');
            $table->time('appTime');
            $table->string('symptom');
            $table->foreign('patientId')->references('patientId')->on('patient');
            $table->foreign('doctorId')->references('doctorId')->on('doctor');
        });

        Schema::create('leaving', function (Blueprint $table) {
            $table->increments('leavingId');
            $table->integer('doctorId')->unsigned();
            $table->date('leaveDate');
            $table->char('leavePeriod',1);
            $table->foreign('doctorId')->references('doctorId')->on('doctor');
        });

        Schema::create('petition', function (Blueprint $table) {
            $table->increments('petitionId');
            $table->integer('pharmacistId')->unsigned();
            $table->integer('doctorId')->unsigned();
            $table->boolean('isReaded');
            $table->date('petitionDate');
            $table->string('prtitionNote');
            $table->foreign('pharmacistId')->references('pharmacistId')->on('pharmacist');
            $table->foreign('doctorId')->references('doctorId')->on('doctor');
        });

        Schema::create('vitalSignData', function (Blueprint $table) {
            $table->increments('vitalSignDataId');
            $table->integer('patientId')->unsigned();
            $table->integer('nurseId')->unsigned();
            $table->date('vitalSignDataDate');
            $table->float('height')->unsigned();
            $table->float('weight')->unsigned();
            $table->float('temperature')->unsigned();
            $table->integer('pulse')->unsigned();
            $table->integer('systolic')->unsigned();
            $table->integer('diastolic')->unsigned();
            $table->foreign('patientId')->references('patientId')->on('patient');
            $table->foreign('nurseId')->references('nurseId')->on('nurse');
        });

        Schema::create('diagnosis', function (Blueprint $table) {
            $table->increments('diagnosisId');
            $table->integer('patientId')->unsigned();
            $table->integer('doctorId')->unsigned();
            $table->date('diagnosisDate');
            $table->string('symptomcode');
            $table->string('diagnosisDetail');
            $table->foreign('patientId')->references('patientId')->on('patient');
            $table->foreign('doctorId')->references('doctorId')->on('doctor');
        });

        Schema::create('prescription', function (Blueprint $table) {
            $table->increments('prescriptionId');
            $table->integer('pharmacistId')->unsigned()->nullable();
            $table->integer('diagnosisId')->unsigned();
            $table->date('prescriptionDate');
            $table->boolean('isApproved')->nullable();
            $table->foreign('pharmacistId')->references('pharmacistId')->on('pharmacist');
            $table->foreign('diagnosisId')->references('diagnosisId')->on('diagnosis');
        });

        Schema::create('drug', function (Blueprint $table) {
            $table->increments('drugId');
            $table->integer('prescriptionId')->unsigned();
            $table->string('drugName');
            $table->string('drugUsage');
            $table->integer('drugAmount')->unsigned();
            $table->foreign('prescriptionId')->references('prescriptionId')->on('prescription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug');
        Schema::dropIfExists('prescription');
        Schema::dropIfExists('diagnosis');
        Schema::dropIfExists('vitalSignData');
        Schema::dropIfExists('petition');
        Schema::dropIfExists('leaving');
        Schema::dropIfExists('appointment');
        Schema::dropIfExists('schedule');
        Schema::dropIfExists('department');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('pharmacist');
        Schema::dropIfExists('nurse');
        Schema::dropIfExists('doctor');
        Schema::dropIfExists('patient');
        Schema::dropIfExists('user');
    }
}
