<?php
use Illuminate\Database\Migrations\Migration;

class AddPartialAmountToInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function ($table) {
            $table->decimal('partial', 13, 2)->nullable();
        });
        Schema::table('companies', function ($table) {
            $table->boolean('utf8_invoices')->default(true);
            $table->boolean('auto_wrap')->default(false);
            $table->string('subdomain')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function ($table) {
            $table->dropColumn('partial');
        });
        Schema::table('companies', function ($table) {
            if (Schema::hasColumn('companies', 'utf8_invoices')) {
                $table->dropColumn('utf8_invoices');
            }
            if (Schema::hasColumn('companies', 'auto_wrap')) {
                $table->dropColumn('auto_wrap');
            }
            $table->dropColumn('subdomain');
        });
    }
}
