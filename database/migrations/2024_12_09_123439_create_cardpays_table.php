
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardpaysTable extends Migration
{
    public function up()
    {
        Schema::create('cardpays', function (Blueprint $table) {
            $table->id();  // This will create an auto-incrementing primary key
            $table->string('name');  // Column for the name
            $table->string('email');  // Column for the email
            $table->string('mobile_no');  // Column for the mobile number
            $table->decimal('total_amount', 10, 2);  // Column for the total amount (decimal with 2 decimal places)
            $table->timestamps();  // Timestamps for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('cardpays');  // Drop the table if it exists (on rollback)
    }
}
