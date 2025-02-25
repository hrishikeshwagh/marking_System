<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->string('grade', 5)->nullable()->after('marks_obtained');
        });
    }

    public function down()
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropColumn('grade');
        });
    }
};
