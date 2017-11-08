<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSettingItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('settings_id');
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('type');
            $table->text('description');
            $table->integer('sort')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_items');
    }
}
