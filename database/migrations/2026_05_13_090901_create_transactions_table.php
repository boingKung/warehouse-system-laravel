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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('type'); // IN, OUT, TRANSFER
        $table->string('status')->default('COMPLETED'); // PENDING, IN_TRANSIT, COMPLETED
        $table->foreignId('employee_id')->constrained()->onDelete('restrict');
        $table->foreignId('from_warehouse_id')->nullable()->constrained('warehouses')->onDelete('restrict');
        $table->foreignId('to_warehouse_id')->nullable()->constrained('warehouses')->onDelete('restrict');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
