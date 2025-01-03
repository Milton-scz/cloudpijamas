<?php

use App\Models\Pago;
use App\Models\User;
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
        Schema::create('ventas', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Pago::class);
            $table->string('fecha');
            $table->integer('metodopago');
            $table->decimal('montototal',8,2);
            $table->integer('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
