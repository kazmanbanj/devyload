<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannelIdToThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->bigInteger('channel_id')->unsigned()->after('user_id');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
            $table->bigInteger('best_reply_id')->unsigned()->after('channel_id')->nullable();
            $table->foreign('best_reply_id')->references('id')->on('replies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropForeign('threads_channel_id_foreign');
            $table->dropColumn('channel_id');
            $table->dropForeign('threads_best_reply_id_foreign');
            $table->dropColumn('best_reply_id');
        });
    }
}
