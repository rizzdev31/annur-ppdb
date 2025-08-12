<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;
use App\Models\Gelombang;
use App\Models\Token;
use App\Models\Fasilitas;
use App\Models\Program;
use App\Models\Berita;
use App\Models\Pendaftaran;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create Tahun Ajaran
        $tahunAjaran = TahunAjaran::create([
            'tahun' => '2025/2026',
            'is_active' => true
        ]);

        // Create Gelombang
        $gelombang = Gelombang::create([
            'tahun_ajaran_id' => $tahunAjaran->id,
            'nama_gelombang' => 'Gelombang 1',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(2),
            'kuota' => 100,
            'is_active' => true
        ]);

        // Generate Tokens
        $tokens = [];
        for ($i = 1; $i <= 10; $i++) {
            $tokens[] = [
                'token' => 'TEST' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'gelombang_id' => $gelombang->id,
                'is_used' => false,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        Token::insert($tokens);

        // Create Fasilitas
        $fasilitas = [
            ['nama' => 'Masjid', 'deskripsi' => 'Masjid yang luas untuk ibadah', 'foto' => 'dummy.jpg', 'urutan' => 1, 'is_active' => true],
            ['nama' => 'Perpustakaan', 'deskripsi' => 'Perpustakaan dengan koleksi lengkap', 'foto' => 'dummy.jpg', 'urutan' => 2, 'is_active' => true],
            ['nama' => 'Lab Komputer', 'deskripsi' => 'Laboratorium komputer modern', 'foto' => 'dummy.jpg', 'urutan' => 3, 'is_active' => true],
            ['nama' => 'Lapangan Olahraga', 'deskripsi' => 'Lapangan olahraga multifungsi', 'foto' => 'dummy.jpg', 'urutan' => 4, 'is_active' => true],
            ['nama' => 'Asrama', 'deskripsi' => 'Asrama nyaman untuk santri', 'foto' => 'dummy.jpg', 'urutan' => 5, 'is_active' => true],
        ];
        
        foreach ($fasilitas as $f) {
            Fasilitas::create($f);
        }

        // Create Programs
        $programs = [
            ['nama' => 'Tahfidz Quran', 'deskripsi' => 'Program hafalan 30 juz', 'foto' => 'dummy.jpg', 'urutan' => 1, 'is_active' => true],
            ['nama' => 'Bahasa Arab', 'deskripsi' => 'Program intensif bahasa Arab', 'foto' => 'dummy.jpg', 'urutan' => 2, 'is_active' => true],
            ['nama' => 'Leadership', 'deskripsi' => 'Program pengembangan kepemimpinan', 'foto' => 'dummy.jpg', 'urutan' => 3, 'is_active' => true],
            ['nama' => 'Entrepreneurship', 'deskripsi' => 'Program kewirausahaan santri', 'foto' => 'dummy.jpg', 'urutan' => 4, 'is_active' => true],
        ];
        
        foreach ($programs as $p) {
            Program::create($p);
        }

        // Create Berita
        $beritas = [
            [
                'judul' => 'PPDB 2025/2026 Resmi Dibuka',
                'slug' => Str::slug('PPDB 2025/2026 Resmi Dibuka'),
                'konten' => 'Penerimaan Peserta Didik Baru (PPDB) untuk tahun ajaran 2025/2026 telah resmi dibuka. Pendaftaran dapat dilakukan secara online melalui website resmi kami. Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik.',
                'foto' => 'dummy.jpg',
                'penulis' => 'Admin PPDB',
                'is_published' => true,
                'published_at' => now()
            ],
            [
                'judul' => 'Prestasi Gemilang Santri di Olimpiade Sains',
                'slug' => Str::slug('Prestasi Gemilang Santri di Olimpiade Sains'),
                'konten' => 'Santri kami berhasil meraih medali emas dalam Olimpiade Sains Nasional. Prestasi ini membuktikan kualitas pendidikan yang kami berikan.',
                'foto' => 'dummy.jpg',
                'penulis' => 'Humas',
                'is_published' => true,
                'published_at' => now()->subDays(5)
            ],
            [
                'judul' => 'Workshop Parenting untuk Orang Tua Santri',
                'slug' => Str::slug('Workshop Parenting untuk Orang Tua Santri'),
                'konten' => 'Akan diadakan workshop parenting untuk orang tua santri. Acara ini bertujuan untuk meningkatkan sinergi antara sekolah dan orang tua dalam mendidik anak.',
                'foto' => 'dummy.jpg',
                'penulis' => 'Koordinator Acara',
                'is_published' => true,
                'published_at' => now()->subDays(10)
            ],
        ];
        
        foreach ($beritas as $b) {
            Berita::create($b);
        }

        // Create Sample Pendaftaran
        $pendaftaran = Pendaftaran::create([
            'token' => 'TEST0001',
            'nisn' => '1234567890',
            'nama_lengkap' => 'Ahmad Test Santri',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2010-01-01',
            'anak_ke' => 1,
            'jumlah_saudara' => 2,
            'nama_ayah' => 'Bapak Test',
            'nama_ibu' => 'Ibu Test',
            'pekerjaan_ayah' => 'Wiraswasta',
            'pekerjaan_ibu' => 'IRT',
            'pendidikan_ayah' => 'S1',
            'pendidikan_ibu' => 'SMA',
            'provinsi' => 'Jawa Timur',
            'kota' => 'Surabaya',
            'kecamatan' => 'Sukolilo',
            'alamat_lengkap' => 'Jl. Test No. 123',
            'asal_sekolah' => 'SD Test',
            'no_whatsapp' => '081234567890',
            'bukti_pembayaran' => 'dummy.jpg',
            'password' => Hash::make('password123'),
            'status' => 'pending',
            'gelombang_id' => $gelombang->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
        ]);

        $this->command->info('Test data created successfully!');
        $this->command->info('Sample Token: TEST0001');
        $this->command->info('Sample Login: NISN: 1234567890 / Password: password123');
    }
}