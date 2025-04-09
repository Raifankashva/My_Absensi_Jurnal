<!DOCTYPE html>
<html>

<head>
    <title>Kartu Peserta Seleksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .kartu-peserta-seleksi {
            padding: 16px;
            width: 415px;
            border: 1px solid black;
        }

        .kartu-peserta-seleksi p {
            font-size: 8pt;
        }

        .kartu-peserta-seleksi td,
        .kartu-peserta-seleksi .footer-wrapper p {
            font-size: 9.5pt;
        }

        .kartu-peserta-seleksi .head-wrapper {
            display: flex;
            padding: 8pt;
            flex-direction: row;
            margin: -16px -16px 0;
            align-items: center;
            justify-content: center;
            border-bottom: 2px solid black;
        }

        .kartu-peserta-seleksi .head-wrapper .sec {
            width: 60px;
            text-align: center;
        }

        .kartu-peserta-seleksi .head-wrapper .sec:nth-child(2) {
            flex: 1;
        }

        .kartu-peserta-seleksi .head-wrapper img {
            height: 50px;
        }

        .kartu-peserta-seleksi .head-wrapper .sec:last-child {
            font-weight: 900;
        }

        .kartu-peserta-seleksi .head-wrapper .sec:nth-child(-1n+3) p {
            margin-bottom: 0;
        }

        .kartu-peserta-seleksi .head-wrapper .sec:nth-child(2) p:nth-child(-n+3) {
            font-weight: bold
        }

        .kartu-peserta-seleksi .content-wrapper {
            padding: 16px 0;
        }


        .kartu-peserta-seleksi .content-wrapper tr:nth-last-child(-n+2) td:last-child {
            color: blue;
        }

        .kartu-peserta-seleksi .content-wrapper tr td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        .kartu-peserta-seleksi .footer-wrapper {
            text-align: right;
        }

        .kartu-peserta-seleksi .footer-wrapper p {
            margin-bottom: 0
        }
    </style>
</head>

<body>
    <div class="kartu-peserta-seleksi-wrapper">
        <div class="kartu-peserta-seleksi">
            <div class="head-wrapper">
                <div class="sec"><img class="img-thumbnail" src="/logo.jpg" alt="MA KHAS KEMPEK"></div>
                <div class="sec">
                    <p>KARTU PESERTA</p>
                    <p>SELEKSI PEMINATAN JURASAN</p>
                    <p>MA KHAS KEMPEK KAB. CIREBON</p>
                    <p>TAHUN PELAJARAN 2019/2010</p>
                </div>
                <div class="sec">
                    <p>PESERTA</p>
                </div>
            </div>
            <div class="content-wrapper">
                <table>
                    <tbody>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td>:</td>
                            <td><strong>MAPP-0012-PSB</strong></td>
                        </tr>
                        <tr>
                            <td>Kode Seleksi</td>
                            <td>:</td>
                            <td><strong>ABCD</strong></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><strong>Satya Nadela</strong></td>
                        </tr>
                        <tr>
                            <td>TTL</td>
                            <td>:</td>
                            <td><strong>18 Juni 2001</strong></td>
                        </tr>
                        <tr>
                            <td>Sekolah Asal</td>
                            <td>:</td>
                            <td>SMPN 1 Sleman</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="footer-wrapper">
                <p>Palimanan, 19 Juni 2019</p>
                <p>Kepala Madrasah</p>
                <br><br>
                <p><strong>H. AHMAD ZAENI DAHLAN, Lc., M.Phil.</strong></p>
            </div>
        </div>
    </div>
</body>

</html>