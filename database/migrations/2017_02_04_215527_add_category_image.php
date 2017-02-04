<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryImage extends Migration {
    public function up() {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->default('travel.png');
        });
    }

    public function down() {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
