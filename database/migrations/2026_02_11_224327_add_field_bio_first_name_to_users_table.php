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
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('bio')->nullable()->after('last_name');
            $table->string('phone')->nullable()->after('bio');
            $table->string('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('zip')->nullable()->after('state');
            $table->string('country')->nullable()->after('zip');
            $table->string('avatar')->nullable()->after('country');
            $table->string('facebook_link')->nullable()->after('avatar');
            $table->string('x_link')->nullable()->after('facebook_link');
            $table->string('instagram_link')->nullable()->after('x_link');
            $table->string('linkedin_link')->nullable()->after('instagram_link');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('bio');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip');
            $table->dropColumn('country');
            $table->dropColumn('avatar');
            $table->dropColumn('facebook_link');
            $table->dropColumn('x_link');
            $table->dropColumn('instagram_link');
            $table->dropColumn('linkedin_link');

        });
    }
};
