<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('table_id');
            $table->foreignId('food_detail_id');
            $table->decimal('price', 20, 0);
            $table->integer('quantity');
            $table->decimal('discount', 4, 1)->default(0);
            $table->decimal('discount_value', 20, 0)->default(0);
            $table->decimal('sub_total', 20, 0);
            $table->decimal('after_disc', 20, 0);
            $table->decimal('tax', 20, 0);
            $table->decimal('total', 20, 0);
            $table->text('notes')->nullable();
            $table->boolean('is_sent_to_kitchen')->default(false);
            $table->timestamp('time_sent_to_kitchen')->nullable();
            $table->boolean('is_processed')->default(false);
            $table->timestamp('time_processed')->nullable();
            $table->boolean('is_done')->default(false);
            $table->timestamp('time_done')->nullable();
            $table->boolean('is_checkout')->default(false);
            $table->timestamp('time_checkout')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamp('time_paid')->nullable();
            $table->string('invoice_no')->nullable();
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
        Schema::dropIfExists('carts');
    }
};


// is_sent_to_kitchen = Sent to kitchen
// is_processed = Processed
// is_done = Done
