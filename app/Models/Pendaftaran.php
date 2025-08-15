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
     *
     * @var string
     */
    protected $table = 'pendaftarans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun_ajaran_id',
        'gelombang_id',
        'token',
        'nisn',
        'password',
        'password_changed',
        'original_password',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
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
        'no_whatsapp',
        'ijazah',
        'surat_keterangan_lulus',
        'akta_kelahiran',
        'kartu_keluarga',
        'status',
        'keterangan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'original_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'password_changed' => 'boolean',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
    ];

    /**
     * Get the tahun ajaran that owns the pendaftaran.
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    /**
     * Get the gelombang that owns the pendaftaran.
     */
    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    /**
     * Get the identifier for authentication (username field).
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'nisn';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Scope a query to only include pending pendaftarans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted pendaftarans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDiterima($query)
    {
        return $query->where('status', 'diterima');
    }

    /**
     * Scope a query to only include rejected pendaftarans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Scope a query to only include in selection pendaftarans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSeleksi($query)
    {
        return $query->where('status', 'seleksi');
    }

    /**
     * Get status badge color
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'yellow',
            'seleksi' => 'blue',
            'diterima' => 'green',
            'ditolak' => 'red',
        ][$this->status] ?? 'gray';
    }

    /**
     * Get status text
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'Menunggu Verifikasi',
            'seleksi' => 'Dalam Proses Seleksi',
            'diterima' => 'DITERIMA',
            'ditolak' => 'Tidak Diterima',
        ][$this->status] ?? 'Unknown';
    }
}