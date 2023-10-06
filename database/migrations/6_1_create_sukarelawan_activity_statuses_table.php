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
        Schema::create('sukarelawan_activity_statuses', function (Blueprint $table) {
            $table->string('id', 11);
            $table->string('name', 11);
            $table->string('slug', 11)->unique();

            $table->primary('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sukarelawan_activity_statuses');
    }
};
