<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Dodajemo kolone koje nedostaju za booking
            $table->enum('package', ['beginner', 'advanced', 'pro'])->default('beginner');
            $table->string('time_slot');
            $table->integer('participants')->default(1);
            $table->boolean('helmet')->default(false);
            $table->boolean('insurance')->default(false);
            $table->boolean('video')->default(false);
            $table->text('instructions')->nullable();
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('confirmed');
            
            // Ako kart_id može biti nullable dok se ne odabere kart
            // $table->foreignId('kart_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'package', 'time_slot', 'participants', 'helmet', 
                'insurance', 'video', 'instructions', 'total_price', 'status'
            ]);
        });
    }
};