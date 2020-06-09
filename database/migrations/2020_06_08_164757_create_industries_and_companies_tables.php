<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustriesAndCompaniesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('url', 200);
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 200);
            $table->string('company_url', 200);
            $table->string('cin', 50)->nullable();
            $table->string('status', 50)->default('active');
            $table->string('class', 200)->nullable();
            $table->integer('reg_no')->default(0);
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('roc_code')->nullable();
            $table->integer('total_members')->default(0);
            $table->integer('industry_id')->unsigned();
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
        Schema::dropIfExists('industries');
        Schema::dropIfExists('companies');
    }
}
