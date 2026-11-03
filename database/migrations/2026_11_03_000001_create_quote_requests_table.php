<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Quote requests sent from the contact page. */
    public function up(): void
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 2);
            $table->string('name', 150);
            $table->string('organisation', 150)->nullable();
            $table->string('phone', 40);
            $table->string('email', 190);
            $table->string('pole', 20);
            $table->string('service_type', 200);
            $table->date('project_date');
            $table->string('location', 200);
            $table->string('budget', 100)->nullable();
            $table->text('description');
            // Set once the notification e-mail has actually been sent to the EVENTIA team.
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
