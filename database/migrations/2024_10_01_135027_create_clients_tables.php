<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();



            $table->index('email');
            $table->index('phone');

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

        Schema::create('client_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'client');
        });

        Schema::create('client_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'client');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_revisions');
        Schema::dropIfExists('client_slugs');
        Schema::dropIfExists('clients');
    }
};
