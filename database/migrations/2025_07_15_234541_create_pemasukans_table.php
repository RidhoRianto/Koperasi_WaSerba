<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('pemasukans', function (Blueprint $table) {
        $table->id();
        $table->decimal('jumlah', 15, 2);
        $table->string('keterangan')->nullable();
        $table->date('tanggal');
        $table->timestamps();
    });
    }

};
