<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dhl_merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('account_number');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dhl_merchants');
    }
};
