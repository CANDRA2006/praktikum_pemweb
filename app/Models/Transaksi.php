<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Denda keterlambatan per hari (Rp).
     */
    const DENDA_PER_HARI = 5000;

    /**
     * Kolom yang dapat diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_transaksi',
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'denda',
    ];

    /**
     * Tipe casting untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'denda' => 'integer',
    ];

    /**
     * Relasi ke Anggota (belongsTo).
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    /**
     * Relasi ke Buku (belongsTo).
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Scope untuk filter transaksi yang masih dipinjam.
     */
    public function scopeDipinjam($query)
    {
        return $query->where('status', 'Dipinjam');
    }

    /**
     * Scope untuk filter transaksi yang sudah dikembalikan.
     */
    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'Dikembalikan');
    }

    /**
     * Scope untuk filter transaksi yang sudah melewati tanggal kembali rencana
     * namun belum dikembalikan (terlambat).
     */
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'Dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<', Carbon::today());
    }

    /**
     * Accessor: jumlah hari keterlambatan (0 jika tidak terlambat).
     */
    public function getHariTerlambatAttribute(): int
    {
        $pembanding = $this->tanggal_kembali_aktual ?? Carbon::today();

        if ($pembanding->lte($this->tanggal_kembali_rencana)) {
            return 0;
        }

        return $this->tanggal_kembali_rencana->diffInDays($pembanding);
    }

    /**
     * Accessor: format denda ke Rupiah.
     */
    public function getDendaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->denda, 0, ',', '.');
    }

    /**
     * Accessor: badge HTML untuk status transaksi.
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->status === 'Dipinjam'
            ? '<span class="badge bg-warning text-dark">Dipinjam</span>'
            : '<span class="badge bg-success">Dikembalikan</span>';
    }
}
