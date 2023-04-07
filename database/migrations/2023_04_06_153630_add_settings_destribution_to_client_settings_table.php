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
        Schema::table('client_settings', function (Blueprint $table) {
            $table->boolean('ztmUI')->default(false)->after('client_ip');
            $table->boolean('zoneID')->default(false)->after('ztmUI');
            $table->boolean('zontromat')->default(false)->after('zoneID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_settings', function (Blueprint $table) {
            $table->dropColumn('ztmUI');
            $table->dropColumn('zoneID');
            $table->dropColumn('zontromat');
        });
    }
};
