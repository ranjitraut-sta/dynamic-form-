<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('field_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('icon')->default('fas fa-square');
            $table->text('html_template');
            $table->json('validation_rules')->nullable();
            $table->boolean('has_options')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('field_types');
    }
};