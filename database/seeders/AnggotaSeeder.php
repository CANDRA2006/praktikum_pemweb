<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Carbon\Carbon;

use function Illuminate\Support\now;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anggotaList = [
            [
                'kode_anggota' => 'AGT-001',
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'tanggal_lahir' => '1995-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'Mahasiswa',
                'tanggal_daftar' => now(),
                'status' => 'Aktif',
            ],
            [
                'kode_anggota' => 'AGT-002',
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nur@email.com',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Sudirman No. 25, Bandung',
                'tanggal_lahir' => '1998-08-20',
                'jenis_kelamin' => 'Perempuan',
                'pekerjaan' => 'Pegawai Swasta',
                'tanggal_daftar' => now(),
                'status' => 'Aktif',
            ],
            [
                'kode_anggota' => 'AGT-003',
                'nama' => 'Ahmad Dhani',
                'email' => 'ahmad.dhani@email.com',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Gatot Subroto No. 5, Surabaya',
                'tanggal_lahir' => '1992-03-10',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'Dosen',
                'tanggal_daftar' => now(),
                'status' => 'Aktif',
            ],
            [
                'kode_anggota' => 'AGT-004',
                'nama' => 'Dewi Lestari',
                'email' => 'dewi.lestari@email.com',
                'telepon' => '081234567893',
                'alamat' => 'Jl. Ahmad Yani No. 30, Yogyakarta',
                'tanggal_lahir' => '2000-12-05',
                'jenis_kelamin' => 'Perempuan',
                'pekerjaan' => 'Mahasiswa',
                'tanggal_daftar' => now(),
                'status' => 'Aktif',
            ],
            [
                'kode_anggota' => 'AGT-005',
                'nama' => 'Rizky Febian',
                'email' => 'rizky.feb@email.com',
                'telepon' => '081234567894',
                'alamat' => 'Jl. Diponegoro No. 15, Semarang',
                'tanggal_lahir' => '1997-07-18',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'Wiraswasta',
                'tanggal_daftar' => now(),
                'status' => 'Nonaktif',
            ],

            [
                'kode_anggota' => 'AGT-006',
                'nama' => 'Testing User',
                'email' => 'testing@email.com',
                'telepon' => '081234567895',
                'alamat' => 'Jl. Testing No. 1',
                'tanggal_lahir' => '2001-01-01',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'Programmer',
                'tanggal_daftar' => now(),
                'status' => 'Aktif',
            ],
        ];

        foreach ($anggotaList as $anggota) {
            Anggota::updateOrCreate(
                ['kode_anggota' => $anggota['kode_anggota']],
                $anggota
            );
        }
    }
}
