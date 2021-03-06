<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('platform_id')->nullable();
            $table->string('name', 200);
            $table->string('account', 100)->nullable();
            $table->decimal('usage', 4 , 2)->default(0);
            $table->boolean('backup')->default(true);
            $table->boolean('renew')->default(true);
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
