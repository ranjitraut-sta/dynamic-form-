<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token', 64)->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role_id')->default(0)->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('is_superadmin')->default(0)->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('full_name')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('display_order')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
