<?php
use Illuminate\Database\Migrations\Migration;

class AddTaskProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('staff_id');
            $table->unsignedInteger('customer_id')->index()->nullable();
            $table->string('name')->nullable();
            $table->boolean('is_deleted')->default(false);
            //$table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            //$table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            //$table->foreign('customer_id')->references('id')->on('relations')->onDelete('cascade');
            $table->unsignedInteger('public_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['company_id', 'public_id']);
        });
        Schema::table('tickets', function ($table) {
            $table->unsignedInteger('project_id')->nullable()->index();
            if (Schema::hasColumn('tickets', 'description')) {
                $table->text('description')->change();
            }
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('tickets', function ($table) {
            //$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        // is_deleted to standardize tables
        /*Schema::table('expense_categories', function ($table) {
            $table->boolean('is_deleted')->default(false);
        });*/


        Schema::table('products', function ($table) {
            $table->boolean('is_deleted')->default(false);
        });
        // add 'delete cascase' to resolve error when deleting an account
        Schema::table('account_gateway_tokens', function ($table) {
            //$table->dropForeign('account_gateway_tokens_default_payment_method_id_foreign');
        });
        Schema::table('account_gateway_tokens', function ($table) {
            //$table->foreign('default_payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });
        Schema::table('invoices', function ($table) {
            $table->boolean('is_public')->default(false);
        });
        DB::table('invoices')->update(['is_public' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function ($table) {
            //$table->dropForeign('tasks_project_id_foreign');
            $table->dropColumn('project_id');
        });
        Schema::dropIfExists('projects');
        /*Schema::table('expense_categories', function ($table) {
            $table->dropColumn('is_deleted');
        });*/
        Schema::table('products', function ($table) {
            $table->dropColumn('is_deleted');
        });
        Schema::table('invoices', function ($table) {
            $table->dropColumn('is_public');
        });
    }
}
