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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid("user_id")->primary()->unique();
            $table->string("first_name");
            $table->string("last_name");
            $table->date("date_of_birth");
            $table->string("email")->unique();
            $table->string("password");
            $table->enum("role", ['admin', 'free', 'paid'])->default("free");
            $table->enum("status", ["active", "inactive"])->default("inactive");
            $table->uuid("connected_user_id")->nullable()->unique();
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign("connected_user_id")->references("user_id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
