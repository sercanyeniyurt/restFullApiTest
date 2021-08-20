<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapsuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capsule', function (Blueprint $table) {
            $table->id();
            $table->string('capsule_serial', 255)->nullable();
            $table->string('capsule_id', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('original_launch', 255)->nullable();
            $table->string('original_launch_unix', 255)->nullable();
            $table->integer('landings')->nullable();
            $table->string('type', 255)->nullable();
            $table->string('details', 255)->nullable();
            $table->integer('reuse_count')->nullable();
            $table->tinyInteger('showStatus')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capsule');
    }
}

