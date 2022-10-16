<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_invites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invite_by');
            $table->foreign('invite_by')->references('id')->on('users');
            $table->string('email');
            $table->boolean('is_accepted')->default(0)->nullable();
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
        Schema::dropIfExists('referral_invites');
    }
};
