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
        // Aggiunta chiave esterna per relazione una a molti tra visualizzazioni e appartamento

        Schema::table('views', function (Blueprint $table) {
            $table->foreignId('apartment_id')->after('id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('views', function (Blueprint $table) {
            $table->dropForeign('views_apartment_id_foreign');
            $table->dropColumn('apartment_id');
        });
    }
};
