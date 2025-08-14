<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pendaftaran extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'pendaftarans';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'token',
        'nisn',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'anak_ke',
        'jumlah_saudara',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'provinsi',
        'kota',
        'kecamatan',
        'alamat_lengkap',
        'asal_sekolah',
        'jenjang',
        'no_whatsapp',
        'bukti_pembayaran',
        'ijazah',
        'surat_keterangan_lulus',
        'akta_kelahiran',
        'kartu_keluarga',
        'password',
        'original_password',
        'password_changed',
        'status',
        'is_credentials_sent',
        'credentials_sent_at',
        'gelombang_id',
        'tahun_ajaran_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'original_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'credentials_sent_at' => 'datetime',
        'is_credentials_sent' => 'boolean',
        'password_changed' => 'boolean',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
    ];

    /**
     * Get the password for authentication.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the unique identifier for authentication.
     */
    public function getAuthIdentifierName()
    {
        return 'nisn';
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->nisn;
    }

    /**
     * Relationships
     */
    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}