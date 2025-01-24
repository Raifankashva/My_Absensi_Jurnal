<?php
namespace App\Observers;

use App\Models\DataSiswa;

class DataSiswaObserver
{
    public function created(DataSiswa $siswa)
    {
        if ($siswa->kelas) {
            $siswa->kelas->updateRemainingCapacity();
        }
        if ($siswa->sekolah) {
            $siswa->sekolah->updateTotalSiswa();
        }
    }

    public function deleted(DataSiswa $siswa)
    {
        if ($siswa->kelas) {
            $siswa->kelas->updateRemainingCapacity();
        }
        if ($siswa->sekolah) {
            $siswa->sekolah->updateTotalSiswa();
        }
    }
}