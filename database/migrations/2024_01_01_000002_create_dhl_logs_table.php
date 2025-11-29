<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dhl_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dhl_logs');
    }
};
