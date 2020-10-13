<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sakes', function (Blueprint $table) {
            $table->id();
            $table->string('name',256)->comment('酒名');
            $table->string('name_kana',256)->comment('酒名カナ');
            $table->unsignedSmallInteger('prefecture')->comment('県');
            $table->string('kura',256)->comment('蔵');
            $table->text('memo',1000)->comment('コメント');
            $table->text('comment')->nullable()->comment('コメント');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sakes');
    }
}
