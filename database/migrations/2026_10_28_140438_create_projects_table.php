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
        Schema::create('projects', function (Blueprint $table) {
            $table->id()->autoIncrement();;
            $table->foreignId('klien_id')->constrained('users')->onDelete('cascade');
            $table->string('judul', 100)->notNull();
            $table->text('deskripsi')->notNull();
            $table->string('kategori', 50)->notNull();
            $table->bigInteger('budget_min')->unsigned()->notNull()->default(0);
            $table->bigInteger('budget_max')->unsigned()->notNull()->default(0);
            $table->date('batas_lelang')->notNull();
            $table->string('status', 20)->notNull()->default('terbuka');
            $table->timestamps('created_at')->notNull()->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
