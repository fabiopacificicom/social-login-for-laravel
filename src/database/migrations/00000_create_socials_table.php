<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    // @todo: check for table conflicts
    if (Schema::hasTable('socials')) {
      throw new Exception('socials table already present in the db', 1);
    }

    Schema::create('socials', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('name')->nullable();
      $table->string('share_id');
      $table->text('token');
      $table->timestamps();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('socials');
  }
};
