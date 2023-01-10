<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('organization_type_id');
            $table->string('organizationname');
            $table->string('address');
            $table->string('mobilenumber');
            $table->string('phonenumber')->nullable();
            $table->string('pan_vat_number');
            $table->string('representativename');
            $table->string('api_key')->unique();
            $table->string('security_key')->unique();
            $table->string('system_base_url');
            $table->string('anydesk_no')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
