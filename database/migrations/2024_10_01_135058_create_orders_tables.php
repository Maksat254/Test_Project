<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            //this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('morphable_id');
            $table->string('morphable_type');
            $table->string('status');
            $table->integer('quantity')->default(1);




            $table->index('user_id');
            $table->index(['morphable_id', 'morphable_type']);

            $table->index('product_id');
            $table->index('service_id');
            $table->index('status');

            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->string('title', 200)->nullable();

            // your generated model and form include a description field, to get you started, but feel free to get rid of it if you don't need it
            $table->text('description')->nullable();

            $table->integer('position')->unsigned()->nullable();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();

            // this will create the required columns to support nesting for this module
            $table->nestedSet();
        });

        Schema::create('order_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'order');
        });

        Schema::create('order_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_revisions');
        Schema::dropIfExists('order_slugs');
        Schema::dropIfExists('orders');
    }
};
