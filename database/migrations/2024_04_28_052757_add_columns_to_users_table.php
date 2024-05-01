<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('alamat');
            $table->string('nomor_telpon');
            $table->string('roles');
            $table->string('jenis_kelamin');
            $table->string('photo_profile')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'nomor_telpon', 'roles', 'jenis_kelamin', 'photo_profile']);
        });
    }
}
