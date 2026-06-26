@extends('layouts.app')

@section('title', 'Pinjam Buku')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">Pinjam Buku</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-plus-circle"></i>
                    Form Peminjaman Buku
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Anggota --}}
                    <div class="mb-3">
                        <label for="anggota_id" class="form-label">
                            Pilih Anggota <span class="text-danger">*</span>
                        </label>
                        <select name="anggota_id"
                                id="anggota_id"
                                class="form-select @error('anggota_id') is-invalid @enderror">
                            <option value="">-- Pilih Anggota --</option>
                            @forelse ($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ (string) old('anggota_id') === (string) $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->kode_anggota }} - {{ $anggota->nama }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada anggota aktif</option>
                            @endforelse
                        </select>
                        @error('anggota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Hanya anggota dengan status Aktif yang dapat meminjam</small>
                    </div>

                    {{-- Pilih Buku --}}
                    <div class="mb-3">
                        <label for="buku_id" class="form-label">
                            Pilih Buku <span class="text-danger">*</span>
                        </label>
                        <select name="buku_id"
                                id="buku_id"
                                class="form-select @error('buku_id') is-invalid @enderror">
                            <option value="">-- Pilih Buku --</option>
                            @forelse ($bukus as $buku)
                                <option value="{{ $buku->id }}"
                                    {{ (string) old('buku_id', $selectedBukuId) === (string) $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }} - (Stok: {{ $buku->stok }})
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada buku tersedia</option>
                            @endforelse
                        </select>
                        @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Hanya buku dengan stok tersedia yang dapat dipinjam</small>
                    </div>

                    <div class="row">
                        {{-- Tanggal Pinjam --}}
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pinjam" class="form-label">
                                Tanggal Pinjam <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="tanggal_pinjam"
                                   id="tanggal_pinjam"
                                   class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}">
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lama Pinjam --}}
                        <div class="col-md-6 mb-3">
                            <label for="lama_pinjam" class="form-label">
                                Lama Pinjam (hari)
                            </label>
                            <input type="number"
                                   name="lama_pinjam"
                                   id="lama_pinjam"
                                   class="form-control @error('lama_pinjam') is-invalid @enderror"
                                   value="{{ old('lama_pinjam', 7) }}"
                                   min="1" max="30">
                            @error('lama_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Default 7 hari, maksimal 30 hari</small>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Informasi Peminjaman:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Tanggal kembali dihitung otomatis dari tanggal pinjam + lama pinjam</li>
                            <li>Denda keterlambatan: <strong>Rp {{ number_format(\App\Models\Transaksi::DENDA_PER_HARI, 0, ',', '.') }}/hari</strong></li>
                            <li>Stok buku akan berkurang otomatis setelah peminjaman diproses</li>
                        </ul>
                    </div>

                    <hr>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Proses Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
