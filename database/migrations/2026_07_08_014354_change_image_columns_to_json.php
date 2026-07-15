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
        Schema::table('beritas', function (Blueprint $table) {
            $table->longText('gambar')->change();
        });
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->longText('foto')->change();
        });
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->longText('gambar')->change();
        });
        Schema::table('galeris', function (Blueprint $table) {
            $table->longText('gambar')->change();
        });
        Schema::table('prestasis', function (Blueprint $table) {
            $table->longText('gambar')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('gambar', 255)->change();
        });
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->string('foto', 255)->change();
        });
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->string('gambar', 255)->change();
        });
        Schema::table('galeris', function (Blueprint $table) {
            $table->string('gambar', 255)->change();
        });
        Schema::table('prestasis', function (Blueprint $table) {
            $table->string('gambar', 255)->change();
        });
    }
};
