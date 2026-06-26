@extends('layouts.app')

@section('title', 'Detail Transaksi ' . $transaksi->kode_transaksi)

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">{{ $transaksi->kode_transaksi }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-receipt"></i>
                    Detail Transaksi
                </h4>
                @if ($transaksi->status === 'Dipinjam')
                    <span class="badge bg-warning text-dark fs-6">Dipinjam</span>
                @else
                    <span class="badge bg-light text-success fs-6">Dikembalikan</span>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td width="220" class="fw-bold"><i class="bi bi-upc text-primary"></i> Kode Transaksi</td>
                        <td>: <code>{{ $transaksi->kode_transaksi }}</code></td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="bi bi-person text-primary"></i> Anggota</td>
                        <td>:
                            <a href="{{ route('anggota.show', $transaksi->anggota_id) }}">
                                {{ $transaksi->anggota->nama }}
                            </a>
                            ({{ $transaksi->anggota->kode_anggota }})
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="bi bi-book text-primary"></i> Buku</td>
                        <td>:
                            <a href="{{ route('buku.show', $transaksi->buku_id) }}">
                                {{ $transaksi->buku->judul }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="bi bi-calendar-check text-primary"></i> Tanggal Pinjam</td>
                        <td>: {{ $transaksi->tanggal_pinjam->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i class="bi bi-calendar-event text-primary"></i> Tanggal Kembali (Rencana)</td>
                        <td>
                            : {{ $transaksi->tanggal_kembali_rencana->format('d F Y') }}
                            @if ($transaksi->status === 'Dipinjam' && $transaksi->tanggal_kembali_rencana->isPast())
                                <span class="badge bg-danger ms-1">
                                    Terlambat {{ $transaksi->hari_terlambat }} hari
                                </span>
                            @endif
                        </td>
                    </tr>
                    @if ($transaksi->tanggal_kembali_aktual)
                        <tr>
                            <td class="fw-bold"><i class="bi bi-calendar2-check text-primary"></i> Tanggal Dikembalikan</td>
                            <td>: {{ $transaksi->tanggal_kembali_aktual->format('d F Y') }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="fw-bold"><i class="bi bi-cash-coin text-primary"></i> Denda</td>
                        <td>
                            : @if ($transaksi->denda > 0)
                                <span class="text-danger fw-semibold">{{ $transaksi->denda_format }}</span>
                            @else
                                Rp 0
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>

                    @if ($transaksi->status === 'Dipinjam')
                        <form action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-box-arrow-in-down"></i> Tandai Dikembalikan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
