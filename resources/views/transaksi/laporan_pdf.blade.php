<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 2px;
        }
        .subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 5px 7px;
            text-align: left;
        }
        thead th {
            background-color: #1d4ed8;
            color: #ffffff;
        }
        tbody tr:nth-child(even) {
            background-color: #f3f4f6;
        }
        .summary {
            width: 100%;
            margin-bottom: 14px;
        }
        .summary td {
            border: none;
            padding: 4px 0;
        }
        .summary .label {
            color: #6b7280;
            width: 160px;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            color: #ffffff;
        }
        .badge-dipinjam {
            background-color: #f59e0b;
        }
        .badge-dikembalikan {
            background-color: #16a34a;
        }
        .footer-note {
            margin-top: 18px;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi Peminjaman</h1>
    <div class="subtitle">Sistem Perpustakaan &mdash; dicetak pada {{ now()->format('d F Y H:i') }}</div>

    <table class="summary">
        <tr>
            <td class="label">Total Transaksi</td>
            <td>: <strong>{{ $totalTransaksi }}</strong></td>
            <td class="label">Total Denda</td>
            <td>: <strong>Rp {{ number_format($totalDenda, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th class="text-right">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $transaksi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                    <td>{{ $transaksi->anggota->nama }}</td>
                    <td>{{ $transaksi->buku->judul }}</td>
                    <td>{{ $transaksi->tanggal_pinjam->format('d-m-Y') }}</td>
                    <td>{{ $transaksi->tanggal_kembali_rencana->format('d-m-Y') }}</td>
                    <td>
                        @if ($transaksi->status === 'Dipinjam')
                            <span class="badge badge-dipinjam">Dipinjam</span>
                        @else
                            <span class="badge badge-dikembalikan">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="text-right">
                        {{ $transaksi->denda > 0 ? 'Rp ' . number_format($transaksi->denda, 0, ',', '.') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        Dokumen ini dibuat otomatis oleh Sistem Perpustakaan dan tidak memerlukan tanda tangan basah.
    </div>
</body>
</html>
