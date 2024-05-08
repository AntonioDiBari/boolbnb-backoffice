<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title_desc', 60);
            $table->string('slug', 60)->unique()->nullable();
            $table->tinyInteger('n_rooms');
            $table->tinyInteger('n_bathrooms');
            $table->tinyInteger('n_beds');
            $table->smallInteger('square_mts');
            $table->string('img')->nullable();
            $table->boolean('visible')->default(0);
            $table->decimal('latitude', 7, 5);
            $table->decimal('longitude', 8, 5);
            $table->softDeletes();
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
        Schema::dropIfExists('apartments');
    }
};
