<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswerColumnToChallengeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenge', function (Blueprint $table) {
            if (!Schema::hasColumn('challenge', 'answer')) {
                $table->string('answer')->nullable()->after('filename');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challenge', function (Blueprint $table) {
            if (Schema::hasColumn('challenge', 'answer')) {
                $table->dropColumn('answer');
            }
        });
    }
}
