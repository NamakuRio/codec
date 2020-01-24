<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('setting_group_id')->unsigned();
            $table->string('name');
            $table->text('value')->nullable();
            $table->text('default_value')->nullable();
            $table->enum('type', ['text', 'email', 'number', 'file', 'textarea']);
            $table->string('comment')->nullable();
            $table->tinyInteger('required')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('setting_group_id')->references('id')->on('setting_groups')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
