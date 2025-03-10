<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\DataSiswa;

class AbsensiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $siswa;
    public $status;
    public $waktu_scan;

    /**
     * Create a new message instance.
     */
    public function __construct(DataSiswa $siswa, $status, $waktu_scan)
    {
        $this->siswa = $siswa;
        $this->status = $status;
        $this->waktu_scan = $waktu_scan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Notifikasi Absensi Siswa')
                    ->view('emails.absensi_notification');
    }
}
