<?php

namespace App\Services\Midtrans;

use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken($id)
    {
        $pesananproduk = DB::table('pesanan_produk')
            ->join('produk_ukuran', 'pesanan_produk.produk_ukuran_id', '=', 'produk_ukuran.id')
            ->join('produk', 'produk_ukuran.produk_id', '=', 'produk.id')
            ->where('pesanan_produk.pesanan_id', $id)
            ->get(['pesanan_produk.*', 'produk.nama as nama_produk', 'produk_ukuran.ukuran as ukuran_produk']);

        // $pesananproduk sekarang berisi data pesanan_produk beserta nama_produk dari tabel produk


        $pesanan = DB::table('pesanan')
            ->where('id', $id)
            ->get();

        $total_harga = DB::table('pesanan_produk')
            ->where('pesanan_id', $id)
            ->sum(DB::raw('harga * jumlah'));


        if ($pesanan->first()->status_pembayaran == 'Menunggu Pembayaran') {
            $params = [
                'transaction_details' => [
                    'order_id' => "DP-" . $pesanan->first()->kode,
                    'gross_amount' => $pesanan->first()->total_harga,
                    'expiry' => [
                        'start_time' => date('Y-m-d H:i:s'), // Waktu mulai transaksi, misalnya sekarang
                        'unit' => 'year', // Satuan waktu (year, month, day, hour, minute)
                        'duration' => null // Waktu kadaluarsa tak terbatas
                    ],
                ],
                'customer_details' => [
                    'first_name' => session('nama_user'),
                    'email' => session('email_user'),
                    'phone' => session('nomor_telepon'),
                ]
            ];

            $totalHarga = $pesanan->first()->total_harga;
            $dpAmount = $totalHarga * 0.3; // 30% dari total harga

            // foreach ($pesananproduk as $item) {
            $params['item_details'][] = [
                'id' => $pesanan->first()->kode, // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
                'price' => $dpAmount, // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
                'quantity' => 1, // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
                'name' => 'DP Pembayaran', // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
            ];
            // }
        } elseif ($pesanan->first()->status_pembayaran == 'Menunggu Pelunasan') {
            $params = [
                'transaction_details' => [
                    'order_id' => "LUNAS-" . $pesanan->first()->kode,
                    'gross_amount' => $pesanan->first()->total_harga,
                    'expiry' => [
                        'start_time' => date('Y-m-d H:i:s'), // Waktu mulai transaksi, misalnya sekarang
                        'unit' => 'year', // Satuan waktu (year, month, day, hour, minute)
                        'duration' => null // Waktu kadaluarsa tak terbatas
                    ],
                ],
                'customer_details' => [
                    'first_name' => session('nama_user'),
                    'email' => session('email_user'),
                    'phone' => session('nomor_telepon'),
                ]
            ];

            foreach ($pesananproduk as $item) {
                // Kurangkan DP dari harga produk
                $hargaSetelahDP = $item->harga - ($item->harga * 0.3);

                $params['item_details'][] = [
                    'id' => $item->id, // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
                    'price' => $hargaSetelahDP, // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
                    'quantity' => $item->jumlah, // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
                    'name' => $item->nama_produk . " " . $item->ukuran_produk, // Gantilah dengan atribut yang sesuai dari tabel pesanan_produk
                ];
            }
        }

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
