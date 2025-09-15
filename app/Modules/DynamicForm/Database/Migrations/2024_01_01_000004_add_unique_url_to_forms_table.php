<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->string('unique_url', 20)->unique()->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('unique_url');
        });
    }
};