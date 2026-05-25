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
    Schema::table('users', function (Blueprint $table) {
        // On ajoute la colonne 'role' avec 'client' par défaut
        $table->string('role')->default('client')->after('email');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // En cas de rollback, on supprime la colonne
        $table->dropColumn('role');
    });
}
};
