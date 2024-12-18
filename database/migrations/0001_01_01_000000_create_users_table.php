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
        
        // Drop existing 'users' table if it exists
        Schema::dropIfExists('users');
        
        // Create 'users' table
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Specify the storage engine
            $table->bigIncrements('userID'); // Primary key
            $table->string('name'); // User name
            $table->string('email')->unique(); // Unique email
            $table->string('password'); // Password
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')->references('id_role')->on('roles');
            $table->string('phone'); // Phone number
            $table->string('image')->nullable(); // Path or filename of the image
            // $table->rememberToken(); // Remember token for authentication
        });
    

        // Create 'password_reset_tokens' table
        // Schema::create('password_reset_tokens', function (Blueprint $table) {
        //     $table->string('email')->primary(); // Primary key
        //     $table->string('token'); // Reset token
        //     $table->timestamp('created_at')->nullable(); // Token creation timestamp
        // });

        // // Create 'sessions' table
        // Schema::create('sessions', function (Blueprint $table) {
        //     $table->string('id')->primary(); // Session ID
        //     $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Foreign key referencing 'users'
        //     $table->string('ip_address', 45)->nullable(); // IP address
        //     $table->text('user_agent')->nullable(); // User agent
        //     $table->longText('payload'); // Session data
        //     $table->integer('last_activity')->index(); // Last activity timestamp
        // });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
        
        // Drop all tables
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        

    }
};
