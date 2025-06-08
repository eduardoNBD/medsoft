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
            $table->uuid('id')->primary(); 
            $table->string('image', 255)->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('language', length: 5);
            $table->string('role'); 
            $table->string('status')->default('1');  
            $table->tinyInteger('email_sent')->default(0); 
            $table->rememberToken();
            $table->uuid('created_by')->nullable();

            $table->timestamps(); 
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{   
        if (Schema::hasTable('items')) { 
            if (Schema::hasColumn('items', 'created_by')) {
                Schema::table('items', function (Blueprint $table) {
                    $table->dropForeign('items_created_by_foreign');
                    $table->dropColumn('created_by');
                });
            }
        
            // Si la clave foránea existe, elimínala
            if (Schema::hasColumn('items', 'created_by')) {
                Schema::table('items', function (Blueprint $table) {
                    $table->dropForeign('items_created_by_foreign');
                });
            }
        }

        if (Schema::hasTable('expenses')) { 
            if (Schema::hasColumn('expenses', 'created_by')) {
                Schema::table('expenses', function (Blueprint $table) {
                    $table->dropForeign('expenses_created_by_foreign');
                    $table->dropColumn('created_by');
                });
            }
        
            // Si la clave foránea existe, elimínala
            if (Schema::hasColumn('expenses', 'created_by')) {
                Schema::table('expenses', function (Blueprint $table) {
                    $table->dropForeign('expenses_created_by_foreign');
                });
            }
        }

        if (Schema::hasTable('expenses_records')) { 
            if (Schema::hasColumn('expenses_records', 'created_by')) {
                Schema::table('expenses_records', function (Blueprint $table) {
                    $table->dropForeign('expenses_records_created_by_foreign');
                    $table->dropColumn('created_by');
                });
            }
        
            // Si la clave foránea existe, elimínala
            if (Schema::hasColumn('expenses_records', 'created_by')) {
                Schema::table('expenses_records', function (Blueprint $table) {
                    $table->dropForeign('expenses_records_created_by_foreign');
                });
            }
        }

        Schema::dropIfExists('users');
    }
};
