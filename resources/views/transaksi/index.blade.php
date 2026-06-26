@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="mb-0">
        <i class="bi bi-arrow-left-right"></i>
        Daftar Transaksi Peminjaman
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('transaksi.laporan') }}" class="btn btn-outline-secondary">
            <i class="bi bi-file-earmark-bar-graph"></i> Laporan
        </a>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Pinjam Buku
        </a>
    </div>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="text-muted">Total Transaksi</h6>
                <h2>{{ $transaksis->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-body">
                <h6 class="text-muted">Sedang Dipinjam</h6>
                <h2>{{ $transaksis->where('status', 'Dipinjam')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <h6 class="text-muted">Sudah Dikembalikan</h6>
                <h2>{{ $transaksis->where('status', 'Dikembalikan')->count() }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- Filter Status --}}
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('transaksi.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="status" class="form-label mb-1">Filter Status</label>
                <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>
            @if (request('status'))
                <div class="col-md-2">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

{{-- Tabel Transaksi --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                        <td>{{ $transaksi->anggota->nama }}</td>
                        <td>{{ $transaksi->buku->judul }}</td>
                        <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                        <td>
                            {{ $transaksi->tanggal_kembali_rencana->format('d M Y') }}
                            @if ($transaksi->status === 'Dipinjam' && $transaksi->tanggal_kembali_rencana->isPast())
                                <span class="badge bg-danger ms-1">Terlambat</span>
                            @endif
                        </td>
                        <td>
                            @if($transaksi->status == 'Dipinjam')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if ($transaksi->denda > 0)
                                <span class="text-danger fw-semibold">{{ $transaksi->denda_format }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('transaksi.show', $transaksi->id) }}"
                               class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
