<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriList = [
            [
                'nama_kategori' => 'Programming',
                'deskripsi' => 'Buku seputar pemrograman dan bahasa pemrograman',
                'icon' => 'code-slash',
                'warna' => 'primary',
            ],
            [
                'nama_kategori' => 'Database',
                'deskripsi' => 'Buku tentang database dan pengelolaan data',
                'icon' => 'database',
                'warna' => 'success',
            ],
            [
                'nama_kategori' => 'Web Design',
                'deskripsi' => 'Buku desain tampilan web dan UI/UX',
                'icon' => 'palette',
                'warna' => 'info',
            ],
            [
                'nama_kategori' => 'Networking',
                'deskripsi' => 'Buku tentang jaringan komputer',
                'icon' => 'wifi',
                'warna' => 'warning',
            ],
            [
                'nama_kategori' => 'Data Science',
                'deskripsi' => 'Buku analisis data, statistik, dan machine learning',
                'icon' => 'graph-up',
                'warna' => 'danger',
            ],
        ];

        foreach ($kategoriList as $kategori) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }
    }
}
