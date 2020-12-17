<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTagsTable extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->foreignIdFor(User::class)
                ->after('id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
}
