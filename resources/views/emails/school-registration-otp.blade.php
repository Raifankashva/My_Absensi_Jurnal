<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pendaftaran Sekolah</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; color: #374151;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 30px 0;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(to right, #4f46e5, #3b82f6); padding: 30px 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">Verifikasi Pendaftaran Sekolah</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px 40px;">
                            <p style="margin-top: 0; margin-bottom: 16px; font-size: 16px; line-height: 1.6;">
                                Halo <span style="font-weight: 700; color: #1f2937;">{{ $userName }}</span>,
                            </p>
                            
                            <p style="margin-top: 0; margin-bottom: 24px; font-size: 16px; line-height: 1.6;">
                                Terima kasih telah mendaftar di sistem kami. Untuk melanjutkan proses pendaftaran, silakan gunakan kode OTP berikut:
                            </p>
                            
                            <!-- OTP Box -->
                            <div style="background-color: #f9fafb; border: 2px dashed #d1d5db; border-radius: 8px; padding: 20px; margin: 30px 0; text-align: center;">
                                <p style="margin: 0 0 10px 0; font-size: 14px; color: #6b7280;">Kode OTP Anda</p>
                                <div style="font-size: 32px; font-weight: 700; letter-spacing: 8px; color: #4f46e5;">
                                    {{ $otp }}
                                </div>
                                <p style="margin: 10px 0 0 0; font-size: 14px; color: #ef4444;">Berlaku selama 15 menit</p>
                            </div>
                            
                            <p style="margin-top: 0; margin-bottom: 16px; font-size: 16px; line-height: 1.6;">
                                Harap segera melakukan verifikasi untuk menyelesaikan proses pendaftaran Anda.
                            </p>
                            
                            <p style="margin-top: 0; margin-bottom: 16px; font-size: 16px; line-height: 1.6;">
                                Jika Anda tidak melakukan pendaftaran ini, harap abaikan email ini.
                            </p>
                            
                            <!-- Divider -->
                            <div style="height: 1px; background-color: #e5e7eb; margin: 30px 0;"></div>
                            
                            <p style="margin-top: 0; margin-bottom: 8px; font-size: 16px; line-height: 1.6;">
                                Salam Hormat,
                            </p>
                            <p style="margin-top: 0; margin-bottom: 0; font-size: 16px; font-weight: 600; color: #1f2937;">
                                Tim Pendaftaran Sekolah
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 14px; color: #6b7280;">
                                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                            </p>
                            <p style="margin: 10px 0 0 0; font-size: 14px; color: #6b7280;">
                                &copy; 2025 SIAT. Seluruh hak cipta dilindungi.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>