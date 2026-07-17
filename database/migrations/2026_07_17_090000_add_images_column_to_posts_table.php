<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new JSON images column
        Schema::table('posts', function (Blueprint $table) {
            $table->json('images')->nullable()->after('content');
        });

        // Migrate existing data from image_path to images (portable approach)
        $posts = DB::table('posts')->whereNotNull('image_path')->get(['id', 'image_path']);
        foreach ($posts as $post) {
            DB::table('posts')->where('id', $post->id)->update([
                'images' => json_encode([$post->image_path])
            ]);
        }

        // Drop the old single-image column
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('content');
        });

        // Restore first image from JSON array (portable approach)
        $posts = DB::table('posts')->whereNotNull('images')->get(['id', 'images']);
        foreach ($posts as $post) {
            $images = json_decode($post->images, true);
            $firstImage = is_array($images) && !empty($images) ? $images[0] : null;
            DB::table('posts')->where('id', $post->id)->update([
                'image_path' => $firstImage
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
