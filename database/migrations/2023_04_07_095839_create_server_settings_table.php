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
        Schema::create('server_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tablet_name');
            $table->string('serial_number')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->string('version')->nullable();
            $table->string('ip')->nullable();
            $table->binary('public_key');
            $table->binary('private_key');
            $table->boolean('distribute_settings')->default(0);
            $table->timestamp('pinged_at')->nullable();
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
        Schema::dropIfExists('server_settings');
    }
};
