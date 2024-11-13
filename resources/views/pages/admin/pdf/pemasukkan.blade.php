<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemasukkan - Usaha Jaya</title>
    <style>
        /* Gaya dasar untuk PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        .report-title {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #dcdcdc;
            /* Warna latar belakang sedikit lebih gelap untuk th */
        }

        td {
            background-color: #f9f9f9;
            /* Warna latar belakang sedikit abu-abu untuk td */
        }

        .total-container {
            text-align: right;
            margin-top: 20px;
            margin-right: 5%;
        }

        .total-label {
            font-weight: bold;
            font-size: 16px;
            margin-right: 5%;
        }

        .total-amount {
            font-weight: bold;
            font-size: 1.8em;
            /* Sesuaikan ukuran font sesuai dengan preferensi Anda */
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Usaha Jaya</h1>
            <p>Alamat: Jl. Nusukan Tegal Mulyo 21B, RT 01, RW 04</p>
            <p>Telepon: (012) 345-6789</p>
        </div>

        <div class="report-title">Laporan Pemasukkan</div>

        <table>
            <thead>
                <tr>
                    <th>Kode Pesanan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Status Pembayaran</th>
                    <th>Total Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemasukkan as $item)
                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d M Y') }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->status_pembayaran }}</td>
                        <td>Rp
                            {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-container">
            <span class="total-label">Grand Total:</span>
            <span class="total-amount">Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Usaha Jaya. Semua hak dilindungi undang-undang.</p>
        </div>
    </div>
</body>

</html>
