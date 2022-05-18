<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assurances', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_id_fk_3030869')->references('id')->on('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone_number');
            $table->string('nni')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('n_permis')->nullable();
            $table->string('vehicule_type');
            $table->string('vehicule_brand');
            $table->string('vehicule_model');
            $table->string('vehicule_color');
            $table->string('vehicule_chassis');
            $table->string('vehicule_matricule');
            $table->date('vehicule_first_use_date');
            $table->enum('duration', ['1 Month', '3 Months', '6 Months', '1 Year', '2 Years'])->default('1 Year');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('payment_status', ['Paid', 'Unpaid', 'Pending'])->default('Pending');
            $table->string('payment')->nullable();
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
        Schema::dropIfExists('assurances');
    }
}
