<?php

use App\Services\NewsSourceReader;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const URL = 'https://www.sunaulopatrika.com/details/10/5427';

    public function up(): void
    {
        if (! Schema::hasTable('news_items')) {
            return;
        }

        if (DB::table('news_items')->where('source_url', self::URL)->orWhere('source_hash', hash('sha256', self::URL))->exists()) {
            return;
        }

        try {
            $payload = app(NewsSourceReader::class)->read(self::URL);
        } catch (\Throwable $exception) {
            $excerpt = 'गोरखा, पालुङटार — आगामी स्थानीय तहको निर्वाचन नजिकिँदै गर्दा गोरखाको पालुङटार नगरपालिकाको राजनीतिक सरगर्मी तीव्र बन्न थालेको छ।';
            $payload = [
                'source_url' => self::URL,
                'source_hash' => hash('sha256', self::URL),
                'source_name' => 'Sunaulo Patrika',
                'title' => 'पालुङटारको राजनीतिमा नयाँ तरंग: अमेरिकाबाट फर्किएका राकेश राजभटको मेयर यात्राले बढायो चासो',
                'excerpt' => $excerpt,
                'content' => '<p>'.e($excerpt).'</p>',
                'image_url' => null,
                'images' => [],
                'published_at' => null,
            ];
        }

        if (DB::table('news_items')->where('source_hash', $payload['source_hash'])->exists()) {
            return;
        }

        DB::table('news_items')->insert([
            ...$payload,
            'images' => json_encode($payload['images'] ?? [], JSON_UNESCAPED_SLASHES),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Keep the news item and any admin edits when rolling back.
    }
};
