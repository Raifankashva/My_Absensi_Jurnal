<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Informasi Akademik</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .email-header {
            background: linear-gradient(to right, #2563eb, #4f46e5);
            color: white;
            padding: 24px;
            text-align: center;
        }
        
        .email-logo {
            margin-bottom: 16px;
        }
        
        .email-body {
            padding: 32px 24px;
            background-color: #ffffff;
        }
        
        .email-footer {
            background-color: #f9fafb;
            padding: 16px 24px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        
        p {
            margin: 16px 0;
            color: #4b5563;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(to right, #2563eb, #4f46e5);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            margin: 24px 0;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        
        .button:hover {
            background: linear-gradient(to right, #1d4ed8, #4338ca);
        }
        
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 16px;
            margin: 24px 0;
            border-radius: 4px;
        }
        
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 24px 0;
        }
        
        .help-text {
            font-size: 14px;
            color: #6b7280;
        }
        
        .link {
            color: #2563eb;
            text-decoration: none;
        }
        
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="email-logo">
                <!-- Logo placeholder - replace with actual logo -->
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" rx="12" fill="white" fill-opacity="0.2"/>
                    <path d="M7 14.5L12 9.5L17 14.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1>Reset Password</h1>
        </div>
        
        <div class="email-body">
            <p>Halo,</p>
            <p>Kami menerima permintaan untuk reset password akun Anda. Silakan klik tombol di bawah ini untuk melanjutkan proses reset password:</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/reset-password/' . $token) }}" class="button">Reset Password</a>
            </div>
            
            <div class="info-box">
                <p style="margin: 0;">Link ini akan kedaluwarsa dalam 60 menit. Jika Anda tidak meminta reset password, silakan abaikan email ini.</p>
            </div>
            
            <div class="divider"></div>
            
            <p class="help-text">Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan URL berikut ke browser Anda:</p>
            <p style="word-break: break-all; font-size: 14px;">
                <a href="{{ url('/reset-password/' . $token) }}" class="link">{{ url('/reset-password/' . $token) }}</a>
            </p>
            
            <p>Terima kasih,<br>Tim Sistem Informasi Akademik</p>
        </div>
        
        <div class="email-footer">
            <p style="margin: 0;">© {{ date('Y') }} Sistem Informasi Akademik. Hak Cipta Dilindungi.</p>
            <p style="margin: 8px 0 0;">Jika Anda memiliki pertanyaan, silakan hubungi <a href="mailto:support@siakad.com" class="link">support@siakad.com</a></p>
        </div>
    </div>
</body>
</html>

