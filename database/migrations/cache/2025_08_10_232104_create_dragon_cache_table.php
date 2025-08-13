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
        Schema::create('dragonfw_cache', function (Blueprint $table) {
        	$table->bigIncrements('id');
        	$table->string('key')->unique();
        	$table->mediumText('value');
        	$table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dragonfw_cache');
    }
};
