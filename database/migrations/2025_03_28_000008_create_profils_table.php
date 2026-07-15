<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pondok');
            $table->string('pengasuh');
            $table->string('tahun_berdiri');
            $table->integer('jumlah_santri');
            $table->integer('jumlah_ustadz');
            $table->text('alamat');
            $table->string('telepon');
            $table->string('email');
            $table->string('website');
            $table->text('visi');
            $table->text('misi');
            $table->text('sejarah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
