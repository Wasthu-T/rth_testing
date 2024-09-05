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
        Schema::create('klhns', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->uuid();
            $table->foreign('uuid')->references('uuid')->on('users');
            $table->string('nik', 16);
            $table->string('no_ruas', 6);
            $table->string('lat');
            $table->string('long');
            $table->string('loc_phnpt')->nullable();
            $table->string('loc_phntts');
            $table->string('ftktp')->nullable();
            $table->string('survei')->nullable();
            $table->date('tgl_survei')->nullable();
            $table->date('tgl_pelaksanaan')->nullable();
            $table->string('istansi')->nullable();
            $table->longText('alasan');
            $table->longText('note')->nullable();
            $table->enum('status', ['0', '1', '2', '3', '4.1','4.2','4.3','5', '6'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klhns');
    }
};
