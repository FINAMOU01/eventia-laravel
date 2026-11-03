<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Job applications sent from the recruitment page. CV files live in storage/app/private/cv, never in public/. */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 2);
            $table->string('name', 150);
            $table->string('phone', 40);
            $table->string('email', 190);
            $table->string('city', 120);
            $table->string('mission_type', 200);
            $table->text('experience');
            $table->string('cv_path');
            $table->string('cv_original_name');
            $table->string('cv_mime', 120);
            $table->unsignedInteger('cv_size');
            // Set once the notification e-mail (with the CV attached) has actually been sent.
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
