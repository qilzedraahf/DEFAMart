
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $voucher['title'] }} - DEFAMart</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7f6;
            color: #24352c;
        }
        header {
            background: #145638;
            color: white;
            padding: 20px 7%;
            font-size: 25px;
            font-weight: bold;
        }
        header span { color: #ffc928; }
        .container {
            max-width: 760px;
            margin: 40px auto;
            padding: 0 18px;
        }
        .back {
            color: #17623d;
            text-decoration: none;
            font-weight: bold;
        }
        .card {
            margin-top: 22px;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px #0000000d;
        }
        .banner {
            padding: 32px;
            color: white;
            background: linear-gradient(120deg, #e72b30, #e87800);
        }
        .banner.mega {
            background: linear-gradient(120deg, #8525d5, #4434d1);
        }
        .tag {
            display: inline-block;
            background: #ffffff35;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
        }
        h1 { margin: 20px 0 10px; font-size: 30px; }
        .discount { font-size: 20px; font-weight: bold; }
        .content { padding: 28px 32px; }
        .content h2 { margin-top: 0; }
        .condition {
            background: #f2f7f3;
            padding: 15px;
            border-radius: 10px;
            margin: 12px 0;
        }
        .claim {
            width: 100%;
            padding: 15px;
            margin-top: 18px;
            border: 0;
            border-radius: 10px;
            background: #17623d;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .claim:disabled {
            background: #dceee2;
            color: #17623d;
            cursor: default;
        }
        .success {
            padding: 14px;
            border-radius: 10px;
            background: #e1f6e7;
            color: #17623d;
            margin-bottom: 18px;
        }
        .note { color: #68756d; font-size: 13px; line-height: 1.6; }
    </style>
</head>
<body>
    <header>DEFA<span>Mart</span></header>

    <main class="container">
        <a class="back" href="{{ route('shop.index') }}">
            ← Kembali ke Beranda
        </a>

        <section class="card">
            <div class="banner {{ $voucherCode === 'mega-sale' ? 'mega' : '' }}">
                <span class="tag">PROMO DEFAMart</span>
                <h1>{{ $voucher['title'] }}</h1>
                <div class="discount">{{ $voucher['discount'] }}</div>
                <p>{{ $voucher['description'] }}</p>
            </div>

            <div class="content">
                <h2>Syarat dan Ketentuan</h2>

                @if (session('success'))
                    <div class="success">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                <div class="condition">
                    <strong>Minimum belanja</strong><br>
                    {{ $voucher['minimum'] }}
                </div>

                <div class="condition">
                    <strong>Masa berlaku</strong><br>
                    {{ $voucher['period'] }}
                </div>

                <div class="condition">
                    <strong>Ketentuan penggunaan</strong>
                    <ul>
                        <li>Voucher hanya berlaku untuk promo yang dipilih.</li>
                        <li>Diskon mengikuti ketentuan promo.</li>
                        <li>Voucher yang diklaim belum otomatis digunakan saat checkout.</li>
                    </ul>
                </div>

                <p class="note">
                    Perhatikan ketentuan promo sebelum melakukan klaim.
                    Informasi periode dan diskon di halaman ini merupakan
                    contoh dan perlu disesuaikan dengan promo sebenarnya.
                </p>

                <form method="POST"
                      action="{{ route('vouchers.claim', $voucherCode) }}">
                    @csrf

                    <button class="claim" type="submit"
                        {{ $claimed ? 'disabled' : '' }}>
                        {{ $claimed ? '✓ Voucher Berhasil Diklaim' : 'Klaim Voucher Sekarang' }}
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
