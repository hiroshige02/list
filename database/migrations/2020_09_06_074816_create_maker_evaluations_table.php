<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakerEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maker_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sake_id')->comment('酒ID');
            $table->unsignedSmallInteger('sake_degree')->comment('日本酒度');
            $table->unsignedSmallInteger('acidity')->comment('酸度');
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
        Schema::dropIfExists('maker_evaluations');
    }
}
