<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('sweetness')->comment('甘さ');
            $table->unsignedSmallInteger('sour_taste')->comment('酸味');
            $table->unsignedSmallInteger('richness')->comment('味の濃さ');
            $table->unsignedSmallInteger('cost_performance')->comment('コストパフォーマンス');
            $table->unsignedSmallInteger('recommend_point')->comment('おすすめ度');
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
        Schema::dropIfExists('personal_evaluations');
    }
}
