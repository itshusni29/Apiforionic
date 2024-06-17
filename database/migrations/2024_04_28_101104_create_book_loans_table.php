<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('book_id')->unsigned();
            $table->string('status')->default('Dipinjam');
            $table->timestamp('tanggal_peminjaman')->nullable(false);
            $table->timestamp('tanggal_pengembalian')->nullable()->default(null);
            $table->timestamp('tanggal_pengembalian_aktual')->nullable()->default(null);
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

            // Add unique constraint to ensure one book per user at a time
            $table->unique(['user_id', 'book_id', 'status', 'tanggal_pengembalian_aktual']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_loans');
    }
}
?>
