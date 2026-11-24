<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - DEFAMart</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6f4;
            color: #24332b;
        }

        header {
            background: #134e32;
            color: white;
            padding: 20px 8%;
            font-size: 25px;
            font-weight: bold;
        }

        header span { color: #eab308; }

        .container {
            max-width: 650px;
            margin: 45px auto;
            padding: 30px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 20px #00000010;
        }

        h2 { margin-top: 0; }

        .info {
            background: #f0f7f2;
            padding: 18px;
            border-radius: 10px;
            margin: 20px 0;
            line-height: 1.8;
        }

        .total {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 20px;
            font-weight: bold;
            margin: 25px 0;
        }

        .method {
            padding: 15px;
            border: 1px solid #d7dfd9;
            border-radius: 8px;
            margin: 12px 0;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            text-align: center;
            background: #134e32;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #134e32;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>DEFA<span>Mart</span></header>

<div class="container">
    <h2>Pembayaran Pesanan</h2>
    <p>Periksa kembali pesanan dan alamat pengiriman kamu.</p>

    <div class="info">
        <strong>Nomor Pesanan:</strong> #{{ $order->id }}<br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
        <strong>Alamat:</strong> {{ $order->shipping_address }}
    </div>

    <h3>Ringkasan Barang</h3>

    @foreach ($order->items as $item)
        <div class="info">
            {{ $item->product->name ?? 'Produk' }}
            ({{ $item->quantity }} barang)
            <br>
            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
        </div>
    @endforeach

    <div class="total">
        <span>Total Harga</span>
        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
    </div>

    <div class="method">
        <strong>Metode Pembayaran</strong>
        <p>Silakan konfirmasi metode pembayaran kepada admin DEFAMart.</p>
    </div>

    <p style="color:#64748b;font-size:13px">
        Halaman ini menampilkan ringkasan pembayaran. Pembayaran online
        otomatis belum terhubung.
    </p>

    <a href="{{ route('shop.index') }}" class="btn">
        Kembali ke Beranda
    </a>
</div>

</body>
</html>