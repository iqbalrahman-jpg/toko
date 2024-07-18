<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("barang", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("kategori_id");
            $table->string("nama");
            $table->text("deskripsi")->nullable();
            $table->boolean("status")->default(0); // 0 for disabled, 1 for active
            $table->timestamps();

            $table
                ->foreign("kategori_id")
                ->references("id")
                ->on("categories")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("barang");
    }
};