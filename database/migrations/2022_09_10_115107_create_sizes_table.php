<?php

use App\Size;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        $sizes =  ["S", "M", "L", "XL", "XXL"];
        foreach ($sizes as $eachSize) {
            $category = new Size();
            $category->name = $eachSize;
            $category->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
