<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Video metadata (title, description, tags, thumbnail, privacy) — see Inovector\Mixpost\Support\VideoDetails.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mixpost_posts', function (Blueprint $table) {
            $table->json('video_details')->nullable()->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('mixpost_posts', function (Blueprint $table) {
            $table->dropColumn('video_details');
        });
    }
};
