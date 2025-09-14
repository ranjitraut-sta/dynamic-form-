<?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class CreateDashboardManagementTable extends Migration
        {
            public function up()
            {
                Schema::create('dashboardmanagement', function (Blueprint $table) {
                    $table->id();
                    $table->string('example_field');
                    $table->timestamps();
                });
            }

            public function down()
            {
                Schema::dropIfExists('dashboardmanagement');
            }
        }
        