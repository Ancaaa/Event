<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            // Normal:
            $table->increments('id');

            // Notification for:
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Reference from (user, event, etc):
            $table->integer('ref_id')->unsigned()->nullable();
            $table->integer('alt_id')->unsigned()->nullable();

            // Notifications Attrs:
            $table->string('type');
            $table->boolean('seen')->default(false);

            // For custom event handling:
            $table->text('message')->nullable();

            // Extra:
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('notifications');
    }
}
