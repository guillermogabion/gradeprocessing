<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('userId')->unique();
            $table->string('password');
            $table->string('profile')->nullable();
            $table->enum('role', ['admin', 'super_admin', 'teacher']);
            // $table->string('email')->unique()->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->enum('isAdviser', ['yes', 'no'])->default('no');
            // $table->foreignId('organization_id')
            //     ->nullable()
            //     ->constrained('organizations')
            //     ->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
