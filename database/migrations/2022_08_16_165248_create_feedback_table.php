<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('survey_id');
            $table->integer('company_recommendation');
            $table->string('company_satisfaction');
            $table->longText('product_description');
            $table->string('meets_customer_needs');
            $table->string('product_quality');
            $table->string('product_valuability');
            $table->string('customer_service');
            $table->string('product_usage_since');
            $table->string('want_other_products');
            $table->longText('feedback');
            $table->tinyInteger('status')->nullable()->default(1);
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
        Schema::dropIfExists('feedback');
    }
}
