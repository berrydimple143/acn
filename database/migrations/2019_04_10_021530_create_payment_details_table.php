<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->increments('id');
			$table->string('TOKEN', 150)->nullable();          
			$table->string('BILLINGAGREEMENTACCEPTEDSTATUS', 150)->nullable();  
			$table->string('CHECKOUTSTATUS', 150)->nullable();          
			$table->string('TIMESTAMP', 150)->nullable();
			$table->string('CORRELATIONID', 150)->nullable();          
			$table->string('ACK', 150)->nullable();
			$table->string('VERSION', 150)->nullable();          
			$table->string('BUILD', 150)->nullable();
			$table->string('EMAIL', 150)->nullable();  
			$table->string('PAYERID', 150)->nullable();          
			$table->string('PAYERSTATUS', 150)->nullable();
			$table->string('FIRSTNAME', 150)->nullable();          
			$table->string('LASTNAME', 150)->nullable();
			$table->string('COUNTRYCODE', 150)->nullable();          
			$table->string('ADDRESSSTATUS', 150)->nullable();
			$table->string('CURRENCYCODE', 150)->nullable();  
			$table->string('AMT', 150)->nullable();          
			$table->string('ITEMAMT', 150)->nullable();
			$table->string('SHIPPINGAMT', 150)->nullable();          
			$table->string('HANDLINGAMT', 150)->nullable();
			$table->string('TAXAMT', 150)->nullable();          
			$table->string('PAYMENTREQUEST_0_AMT', 150)->nullable();
			$table->string('PAYMENTREQUEST_0_CURRENCYCODE', 150)->nullable();          
			$table->string('L_AMT0', 150)->nullable();
			$table->string('L_TAXAMT0', 150)->nullable();          
			$table->string('L_QTY0', 150)->nullable();
			$table->string('L_NAME0', 150)->nullable();  
			$table->string('INSURANCEOPTIONOFFERED', 150)->nullable();          
			$table->string('SHIPDISCAMT', 150)->nullable();
			$table->string('INSURANCEAMT', 150)->nullable();          
			$table->string('NOTIFYURL', 150)->nullable();
			$table->string('INVNUM', 150)->nullable();          
			$table->string('DESC', 150)->nullable();
			$table->string('PAYMENTREQUEST_0_ITEMAMT', 150)->nullable();  
			$table->string('PAYMENTREQUEST_0_SHIPPINGAMT', 150)->nullable();          
			$table->string('PAYMENTREQUEST_0_HANDLINGAMT', 150)->nullable();
			$table->string('PAYMENTREQUEST_0_TAXAMT', 150)->nullable();          
			$table->string('PAYMENTREQUEST_0_DESC', 150)->nullable();
			$table->string('PAYMENTREQUEST_0_INVNUM', 150)->nullable();          
			$table->string('PAYMENTREQUEST_0_NOTIFYURL', 150)->nullable();
			$table->string('L_PAYMENTREQUEST_0_NAME0', 150)->nullable();  
			$table->string('PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED', 150)->nullable();          
			$table->string('PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID', 150)->nullable();
			$table->string('PAYMENTREQUEST_0_SHIPDISCAMT', 150)->nullable();          
			$table->string('PAYMENTREQUEST_0_INSURANCEAMT', 150)->nullable();
			$table->string('L_PAYMENTREQUEST_0_QTY0', 150)->nullable();          
			$table->string('L_PAYMENTREQUEST_0_TAXAMT0', 150)->nullable();
			$table->string('L_PAYMENTREQUEST_0_AMT0', 150)->nullable();
			$table->string('PAYMENTREQUESTINFO_0_ERRORCODE', 150)->nullable();   			
			$table->string('customer_id', 30)->nullable();   
			$table->string('customer_level', 35)->nullable();   
			$table->string('payment_status', 15)->nullable();   
			$table->string('period', 150)->nullable();
			$table->dateTime('date_paid')->nullable();
			$table->dateTime('date_cancelled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_details');
    }
}
