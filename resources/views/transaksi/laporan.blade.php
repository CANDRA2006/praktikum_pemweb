@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="mb-0">
        <i class="bi bi-file-earmark-bar-graph"></i>
        Laporan Transaksi
    </h1>
    <a href="{{ route('transaksi.laporan.pdf', request()->query()) }}" class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
</div>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('transaksi.laporan') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="dari_tanggal" class="form-label">Dari Tanggal Pinjam</label>
                <input type="date" name="dari_tanggal" id="dari_tanggal" class="form-control"
                       value="{{ request('dari_tanggal') }}">
            </div>
            <div class="col-md-3">
                <label for="sampai_tanggal" class="form-label">Sampai Tanggal Pinjam</label>
                <input type="date" name="sampai_tanggal" id="sampai_tanggal" class="form-control"
                       value="{{ request('sampai_tanggal') }}">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="Semua" {{ request('status', 'Semua') == 'Semua' ? 'selected' : '' }}>Semua</option>
                    <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="anggota_id" class="form-label">Anggota</label>
                <select name="anggota_id" id="anggota_id" class="form-select">
                    <option value="">Semua Anggota</option>
                    @foreach ($anggotaList as $anggota)
                        <option value="{{ $anggota->id }}" {{ (string) request('anggota_id') === (string) $anggota->id ? 'selected' : '' }}>
                            {{ $anggota->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="text-muted">Total Transaksi (sesuai filter)</h6>
                <h2>{{ $totalTransaksi }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-body">
                <h6 class="text-muted">Total Denda</h6>
                <h2>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- Tabel --}}
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                            <td>{{ $transaksi->anggota->nama }}</td>
                            <td>{{ $transaksi->buku->judul }}</td>
                            <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                            <td>{{ $transaksi->tanggal_kembali_rencana->format('d M Y') }}</td>
                            <td>
                                @if ($transaksi->status == 'Dipinjam')
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada transaksi sesuai filter
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
