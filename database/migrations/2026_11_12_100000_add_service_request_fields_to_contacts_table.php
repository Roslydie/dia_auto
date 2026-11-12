<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('service');
            $table->string('year', 4)->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->text('need');
            $table->string('name')->nullable();
            $table->string('phone', 30);
            $table->string('email');
            $table->string('runs')->nullable();
            $table->string('zip', 5)->nullable();
            $table->json('photos')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'service',
                'year',
                'make',
                'model',
                'need',
                'name',
                'phone',
                'email',
                'runs',
                'zip',
                'photos',
            ]);
        });
    }
};
