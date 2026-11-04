<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Job applications sent from the recruitment page.
     * Uploaded documents (CV, cover letter, photos) live in storage/app/private/candidatures, never in public/.
     */
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
            // { cv|cover_letter|photo_portrait|photo_full: { path, name, mime, size } }
            $table->json('documents');
            // Set once the notification e-mail (with the documents attached) has actually been sent.
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
