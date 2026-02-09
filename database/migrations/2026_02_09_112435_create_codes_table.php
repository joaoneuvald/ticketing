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
        Schema::create('tck_codes', function (Blueprint $table) {
            $table->string('code_id')->primary();
            $table->string('authenticatable_id')->index('idx_tck_codes_authenticatable_id');
            $table->integer('code')->index('idx_tck_codes_code');
            $table->integer('type')->index('idx_tck_codes_type');
            $table->integer('status');
            $table->timestamp('expiration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tck_codes');
    }
};
