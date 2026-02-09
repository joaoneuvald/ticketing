<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tck_users', function (Blueprint $table) {
            $table->string('user_id')->primary();
            $table->string('username')->unique()->index('idx_tck_users_usermame');
            $table->string('email')->unique()->index('idx_tck_users_email');
            $table->string('name');
            $table->integer('role')->index('idx_tck_users_role');
            $table->boolean('blocked');
            $table->boolean('readonly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tck_users');
    }
};
