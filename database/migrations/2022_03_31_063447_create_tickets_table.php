<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('organization_id');
            $table->integer('product_id');
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('assigned_to')->nullable();
            $table->bigInteger('problem_type_id');
            $table->bigInteger('problem_category_id')->nullable();
            $table->longText('images')->nullable();
            $table->tinyInteger('priority')->nullable()->default(1);
            $table->string('support_type');
            $table->string('state')->nullable()->default('Created');
            $table->tinyInteger('status')->nullable()->default(2);
            $table->longText('details');
            $table->string('ticket_id')->nullable();
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('tickets');
    }
}
