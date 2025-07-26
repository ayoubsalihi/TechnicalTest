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
        /**
         * cette migration est pour ajouter les colonnes restantes a la table users
         */
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name','full_name');
            $table->string('phone_number')->after('email');
            $table->text('image')->after('phone_number');
            $table->string('adress')->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('full_name','name');
            $table->dropColumn('phone_number');
            $table->dropColumn('image');
            $table->dropColumn('adress');
        });
    }
};
