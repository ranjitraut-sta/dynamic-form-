<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\DynamicForm\Models\Form;

return new class extends Migration
{
    public function up()
    {
        // First add nullable user_id column
        Schema::table('forms', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // Update existing forms to have user_id = 1 (first user)
        Form::whereNull('user_id')->update(['user_id' => 1]);

        // Now make it not nullable and add foreign key
        Schema::table('forms', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};