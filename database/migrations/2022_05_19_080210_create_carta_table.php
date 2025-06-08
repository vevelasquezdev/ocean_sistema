<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaTable extends Migration
{
    
    public function up()
    {
        Schema::create('carta', function (Blueprint $table) {
            $table->id();
            $table->string('tip_pro', 50);
            $table->string('des_pro', 100);
            $table->double('pre_pro', 10, 2);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('carta');
    }
}
