<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $budaya = Category::where('slug', 'budaya')->first();
        $sejarah = Category::where('slug', 'sejarah')->first();
        $tradisi = Category::where('slug', 'tradisi')->first();

        $items = [
            [
                'category_id' => $budaya?->id,
                'title' => 'Asal Usul Danau Taliwang',
                'history_text' => '<p>Pada zaman dahulu, ada seorang pemuda yang tinggal di wilayah Taliwang. Ia dikenal sebagai sosok yang rajin dan berbakti kepada orang tuanya.</p><p>Suatu hari, ia bermimpi tentang sebuah danau yang luas. Setelah melakukan perjalanan panjang dan melewati berbagai ujian, akhirnya terciptalah Danau Taliwang yang kita kenal sekarang.</p><p>Cerita ini mengandung nilai moral tentang kesabaran, kerja keras, dan kearifan lokal masyarakat Sumbawa Barat.</p>',
                'is_new' => true,
            ],
            [
                'category_id' => $budaya?->id,
                'title' => 'Legenda Putri Ranggasela',
                'history_text' => '<p>Alkisah hiduplah seorang putri bernama Ranggasela di tanah Sumbawa. Ia dikenal karena kecantikannya yang luar biasa dan kebaikannya kepada sesama.</p><p>Putri Ranggasela menjadi simbol keindahan dan kearifan budaya Sumbawa yang masih diingat hingga saat ini.</p>',
                'is_new' => false,
            ],
            [
                'category_id' => $tradisi?->id,
                'title' => 'Tradisi Bau Nyale',
                'history_text' => '<p>Bau Nyale adalah tradisi menangkap cacing laut yang dilakukan setiap tahun oleh masyarakat di Lombok dan Sumbawa.</p><p>Tradisi ini berkaitan dengan legenda Putri Mandalika yang menjelma menjadi nyale (cacing laut). Setiap tahun masyarakat berkumpul di pantai untuk menangkap nyale yang dipercaya membawa berkah.</p><p>Tradisi ini menjadi ajang silaturahmi dan pelestarian budaya yang sangat bernilai bagi masyarakat Nusa Tenggara Barat.</p>',
                'is_new' => true,
            ],
            [
                'category_id' => $sejarah?->id,
                'title' => 'Perang Topat',
                'history_text' => '<p>Perang Topat adalah tradisi unik di Lombok yang melibatkan lemparan ketupat antar kelompok masyarakat.</p><p>Meskipun dinamakan "perang", tradisi ini sebenarnya merupakan simbol kerukunan dan persaudaraan. Setelah perang ketupat selesai, para peserta saling berjabat tangan dan meminta maaf.</p><p>Tradisi ini mencerminkan nilai-nilai perdamaian dan toleransi dalam masyarakat Sumbawa dan Lombok.</p>',
                'is_new' => false,
            ],
        ];

        foreach ($items as $data) {
            if (! $data['category_id']) {
                continue;
            }
            $data['slug'] = Str::slug($data['title']);
            $data['published_at'] = now();
            Item::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
