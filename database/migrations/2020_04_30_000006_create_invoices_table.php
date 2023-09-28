<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('period_from');
            $table->date('period_to');
            $table->integer('invoice_number');
            $table->integer('total_amount');
            $table->datetime('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
};
