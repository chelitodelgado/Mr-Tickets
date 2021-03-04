<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kind', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        /* INSERT A TRABLA KIND */
        DB::table('kind')->insert([
            [
                'name'       => 'Ticket'
            ],
            [
                'name'       => 'Bug'
            ],
            [
                'name'       => 'Sugerencia'
            ],
            [
                'name'       => 'Caracteristica'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kind');
    }
}
