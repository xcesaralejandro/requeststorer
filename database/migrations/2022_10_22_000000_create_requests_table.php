<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string("user_id")->nullable();
            $table->string("route_name", 2000)->nullable();
            $table->string("controller", 2000)->nullable();
            $table->string("header_referer")->nullable();
            $table->string("sec_ch_ua")->nullable();
            $table->string("sec_ch_ua_mobile")->nullable();
            $table->string("sec_ch_ua_platform")->nullable();
            $table->string("sec_ch_ua_mode")->nullable();
            $table->string("x-forwarded-for")->nullable();
            $table->string("x-forwarded-host")->nullable();
            $table->string("x-real-ip")->nullable();
            $table->string("action", 2000)->nullable();
            $table->string("method")->nullable();
            $table->text("path_info")->nullable();
            $table->text("uri")->nullable();
            $table->string("query_string")->nullable();
            $table->boolean("is_secure")->nullable();
            $table->boolean("is_ajax")->nullable();
            $table->string("client_ip")->nullable();
            $table->string("client_port")->nullable();
            $table->text("user_agent")->nullable();
            $table->text("referer")->nullable();
            $table->string("server_protocol")->nullable();
            $table->json("params")->nullable();
            $table->text("content")->nullable();
            $table->string("http_response_code")->nullable();
            $table->enum("stored_on", ["arrival", "response"])->nullable();
            $table->string("send_at")->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
