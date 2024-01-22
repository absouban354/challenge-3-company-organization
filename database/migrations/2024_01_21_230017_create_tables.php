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
        Schema::create('companies', function(Blueprint $table){
            $table->id();
            $table->string('name'); //name of the company
            $table->string('industry');
            $table->date('founding_date'); 
            $table->timestamps();
        });
        
        Schema::create('locations', function(Blueprint $table){
            $table->id();
            $table->string('city'); //Name of the location
            $table->string('address'); //Full address of the company
            $table->foreignId('company_id')->constrained();
            $table->timestamps();
        });
       
        Schema::create('assets', function(Blueprint $table){
            $table->id();
            $table->string('name'); //Name of the asset
            $table->decimal('value',10,2); //Value of the asset
            $table->foreignId('company_id')->constrained();
            $table->timestamps();
        });

        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('email');
            $table->string('phone_number');
            $table->timestamps();

        });
        Schema::create('managers',function(Blueprint $table){
            $table->id(); //Manager Id
            $table->string('department');
            $table->string('level');
            $table->foreignId('people_id')->references('id')->on('peoples');
            $table->foreignId('company_id')->constrained();
        });
        Schema::create('employees',function(Blueprint $table){
            $table->id(); //Employee Id
            $table->string('designation');
            $table->string('department');
            $table->foreignId('people_id')->references('id')->on('peoples');
            $table->unsignedBigInteger('company_group_id');
            $table->foreignId('company_id')->constrained();
        });
        Schema::create('company_groups',function(Blueprint $table){
            $table->id(); //Employee Id
            $table->string('group_name');
            $table->foreignId('company_group_head')->nullable()->references('id')->on('employees');
            $table->foreignId('parent_id')->nullable()->references('id')->on('company_groups');
            $table->foreignId('company_id')->nullable()->constrained();
        });
        
        Schema::table('employees',function(Blueprint $table){
            $table->foreign('company_group_id')->nullable()->references('id')->on('company_groups');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peoples');
    }
};
