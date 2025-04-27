<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; }
        .qrcode-container {
            display: flex;
            flex-wrap: wrap;
        }
        .item {
            width: 33.33%;
            padding: 10px;
            text-align: center;
            box-sizing: border-box;
        }
        .item img {
            width: 150px;
            height: 150px;
        }
        .item .info {
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">QR Codes Siswa</h2>
    <div class="qrcode-container">
        @foreach($qrData as $qr)
            <div class="item">
                <img src="{{ $qr['image'] }}" alt="QR">
                <div class="info">
                    <strong>{{ $qr['nama'] }}</strong><br>
                    NISN: {{ $qr['nisn'] }}
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
