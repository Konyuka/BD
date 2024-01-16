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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('bdr_no')->nullable();
            $table->string('purchasing_authority')->nullable();
            $table->string('tender_number')->nullable();
            $table->text('tender_brief')->nullable();
            $table->string('competition_type')->nullable();
            $table->string('funded_by')->nullable();
            $table->string('country')->nullable();
            $table->string('value')->nullable();
            $table->text('work_detail')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('link')->nullable();
            $table->string('expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
