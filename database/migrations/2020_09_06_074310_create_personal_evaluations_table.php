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
            $table->unsignedInteger('sake_id')->comment('酒ID');
            $table->smallInteger('sweetness')->comment('甘さ');
            $table->smallInteger('acidity')->comment('酸味');
            $table->smallInteger('richness')->comment('味の濃さ');
            $table->smallInteger('cost_performance')->comment('コストパフォーマンス');
            $table->smallInteger('recommend_point')->comment('おすすめ度');
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
