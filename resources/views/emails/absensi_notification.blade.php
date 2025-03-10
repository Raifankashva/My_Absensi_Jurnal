<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Absensi Siswa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #3a86ff;
            --secondary: #8338ec;
            --accent: #ff006e;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #38b000;
            --warning: #ffbe0b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #edf2f7;
            margin: 0;
            padding: 20px;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .decorative-shape {
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 0 0 0 100%;
            z-index: 1;
        }
        
        .decorative-dots {
            position: absolute;
            bottom: 20px;
            left: 20px;
            width: 100px;
            height: 100px;
            background-image: radial-gradient(var(--light) 2px, transparent 2px);
            background-size: 10px 10px;
            opacity: 0.5;
            z-index: 0;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: left;
            position: relative;
            z-index: 2;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
            padding-bottom: 50px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .header-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
            font-weight: 300;
        }
        
        .content {
            padding: 30px;
            position: relative;
            z-index: 2;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: var(--dark);
        }
        
        .data-card {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            position: relative;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
        }
        
        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .data-card h3 {
            color: var(--primary);
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .data-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .data-item:last-child {
            margin-bottom: 0;
        }
        
        .data-label {
            flex: 0 0 140px;
            font-weight: 500;
            color: #6c757d;
            font-size: 14px;
        }
        
        .data-value {
            flex: 1;
            font-weight: 600;
            color: var(--dark);
            font-size: 15px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: white;
            background-color: var(--success);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-hadir {
            background-color: var(--success);
        }
        
        .status-terlambat {
            background-color: var(--warning);
            color: var(--dark);
        }
        
        .status-alpha {
            background-color: var(--accent);
        }
        
        .footer {
            text-align: center;
            padding: 25px 20px;
            font-size: 12px;
            color: #6c757d;
            background-color: #f8f9fa;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        .school-logo {
            display: block;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 0 15px 0;
            background-color: white;
            padding: 5px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .thank-you {
            font-size: 16px;
            margin: 25px 0;
            color: var(--dark);
            font-weight: 500;
        }
        
        .social-icons {
            margin: 20px 0;
        }
        
        .social-icons a {
            display: inline-block;
            width: 36px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            margin: 0 5px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }
        
        .social-icons a:hover {
            transform: scale(1.1);
            background-color: var(--secondary);
        }
        
        @media (max-width: 650px) {
            .data-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .data-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="decorative-shape"></div>
        <div class="decorative-dots"></div>
        
        <div class="header">
            <h1>Notifikasi Absensi</h1>
            <div class="header-subtitle">Sistem Informasi Kehadiran Siswa</div>
        </div>
        
        <div class="content">
            <p class="greeting">Kepada Orang Tua/Wali Murid yang Terhormat,</p>
            
            <p>Kami ingin menyampaikan informasi terkait kehadiran putra/putri Anda hari ini:</p>
            
            <div class="data-card">
                <h3>DETAIL KEHADIRAN</h3>
                <div class="data-item">
                    <div class="data-label">Nama Siswa</div>
                    <div class="data-value">{{ $siswa->nama_lengkap }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">NISN</div>
                    <div class="data-value">{{ $siswa->nisn }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Kelas</div>
                    <div class="data-value">{{ $siswa->kelas ?? 'X IPA 1' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Waktu Scan</div>
                    <div class="data-value">{{ $waktu_scan }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Status</div>
                    <div class="data-value">
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $status)) }}">{{ $status }}</span>
                    </div>
                </div>
            </div>
            
            <p class="thank-you">Terima kasih atas perhatian dan kerjasamanya.</p>
            
            <div class="social-icons">
                <a href="#"><i>f</i></a>
                <a href="#"><i>i</i></a>
                <a href="#"><i>y</i></a>
            </div>
        </div>
        
        <div class="footer">
            <p>Pesan ini dikirim secara otomatis oleh Sistem Informasi Akademik</p>
            <p>Harap tidak membalas email ini</p>
            <p>&copy; 2025 - My Absensi Jurnal Sytem By Kashva</p>
        </div>
    </div>

    <script>
        // Animasi sederhana saat loading
        document.addEventListener('DOMContentLoaded', function() {
            const dataCard = document.querySelector('.data-card');
            setTimeout(() => {
                dataCard.style.opacity = '0';
                dataCard.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    dataCard.style.transition = 'all 0.5s ease';
                    dataCard.style.opacity = '1';
                    dataCard.style.transform = 'translateY(0)';
                }, 300);
            }, 100);
            
            // Menentukan warna status badge berdasarkan nilai
            const statusBadge = document.querySelector('.status-badge');
            const statusText = statusBadge.textContent.trim().toLowerCase();
            
            if (statusText.includes('hadir')) {
                statusBadge.classList.add('status-hadir');
            } else if (statusText.includes('terlambat')) {
                statusBadge.classList.add('status-terlambat');
            } else {
                statusBadge.classList.add('status-alpha');
            }
        });
    </script>
</body>
</html>