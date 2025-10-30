<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
    Schema::create('menu', function (Blueprint $table) {
    $table->id();
    $table->string('name', 1000);
    $table->string('link', 1000);
    $table->string('type', 1000);
    $table->enum('position', ['mainmenu', 'footermenu'])->default('mainmenu');
    $table->unsignedInteger('table_id')->nullable();
    $table->unsignedInteger('sort_order')->default(0);
    $table->unsignedInteger('parent_id')->default(0);
    $table->unsignedInteger('created_by');
    $table->unsignedInteger('updated_by')->nullable();
    $table->timestamps();
    $table->softDeletes ('deleted_at');
    $table->unsignedInteger('status');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
};
