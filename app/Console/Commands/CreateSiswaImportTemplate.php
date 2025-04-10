<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateSiswaImportTemplate extends Command
{
    protected $signature = 'siswa:create-template';
    protected $description = 'Create Excel template for student import';

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk mendapatkan huruf kolom (A, B, C, ... Z, AA, AB, ...)
    private function getColumnLetter($index)
    {
        $letters = '';
        while ($index >= 0) {
            $letters = chr($index % 26 + 65) . $letters;
            $index = intdiv($index, 26) - 1;
        }
        return $letters;
    }

    public function handle()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'nama_lengkap', 'email', 'password', 'alamat', 'hp',
            'sekolah_id', 'kelas_id', 'nisn', 'nis', 'nik',
            'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama',
            'province_id', 'city_id', 'district_id', 'village_id', 'kode_pos',
            'tinggal', 'transport', 'nama_ayah', 'email_ayah', 'pekerjaan_ayah',
            'nama_ibu', 'email_ibu', 'pekerjaan_ibu', 'nama_wali', 'email_wali',
            'pekerjaan_wali', 'tinggi_badan', 'berat_badan', 'kks', 'kph', 'kip'
        ];

        // Set column headers
        foreach ($headers as $index => $header) {
            $column = $this->getColumnLetter($index); // Menggunakan fungsi getColumnLetter
            $sheet->setCellValue($column . '1', $header);
            
            // Style header
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
            $sheet->getStyle($column . '1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('DDEBF7');
        }

        // Add sample data
        $sampleData = [
            'John Doe', 'john.doe@example.com', 'password123', 'Jl. Merdeka No. 10', '081234567890',
            '1', '1', '1234567890', '9876543210', '1234567890123456',
            'laki-laki', 'Jakarta', '2005-01-15', 'Islam',
            '11', '1101', '1101010', '1101010001', '12345',
            'Ortu', 'Motor', 'James Doe', 'james.doe@example.com', 'Pegawai Swasta',
            'Jane Doe', 'jane.doe@example.com', 'Guru', '', '',
            '', '170', '65', '123456789', '', ''
        ];

        // Add the sample data
        foreach ($sampleData as $index => $value) {
            $column = $this->getColumnLetter($index); // Menggunakan fungsi getColumnLetter
            $sheet->setCellValue($column . '2', $value);
        }

        // Set up data validation for specific columns
        $jenisKelaminValidation = $sheet->getCell('K2')->getDataValidation();
        $jenisKelaminValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $jenisKelaminValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $jenisKelaminValidation->setAllowBlank(false);
        $jenisKelaminValidation->setShowInputMessage(true);
        $jenisKelaminValidation->setShowErrorMessage(true);
        $jenisKelaminValidation->setShowDropDown(true);
        $jenisKelaminValidation->setFormula1('"laki-laki,Perempuan"');
        
        $agamaValidation = $sheet->getCell('N2')->getDataValidation();
        $agamaValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $agamaValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $agamaValidation->setAllowBlank(false);
        $agamaValidation->setShowInputMessage(true);
        $agamaValidation->setShowErrorMessage(true);
        $agamaValidation->setShowDropDown(true);
        $agamaValidation->setFormula1('"Islam,Kristen,Katolik,Hindu,Buddha,Konghucu"');
        
        $tinggalValidation = $sheet->getCell('T2')->getDataValidation();
        $tinggalValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $tinggalValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $tinggalValidation->setAllowBlank(false);
        $tinggalValidation->setShowInputMessage(true);
        $tinggalValidation->setShowErrorMessage(true);
        $tinggalValidation->setShowDropDown(true);
        $tinggalValidation->setFormula1('"Ortu,Wali,Kost,Asrama,Panti"');
        
        // Add instructions sheet
        $spreadsheet->createSheet();
        $instructionSheet = $spreadsheet->getSheet(1);
        $instructionSheet->setTitle('Petunjuk');
        
        $instructionSheet->setCellValue('A1', 'PETUNJUK PENGISIAN TEMPLATE');
        $instructionSheet->setCellValue('A3', 'Cara Pengisian:');
        $instructionSheet->setCellValue('A4', '1. Isi data sesuai dengan format yang telah disediakan');
        $instructionSheet->setCellValue('A5', '2. Jangan mengubah nama header/kolom');
        $instructionSheet->setCellValue('A6', '3. Pastikan ID sekolah dan kelas yang dimasukkan valid');
        $instructionSheet->setCellValue('A7', '4. Format tanggal lahir: YYYY-MM-DD (contoh: 2005-01-15)');
        $instructionSheet->setCellValue('A8', '5. Kolom wajib diisi: nama_lengkap, email, nisn, nis, nik, dll.');
        
        $instructionSheet->setCellValue('A10', 'ID yang dibutuhkan:');
        $instructionSheet->setCellValue('A11', '- sekolah_id: ID sekolah di sistem');
        $instructionSheet->setCellValue('A12', '- kelas_id: ID kelas di sistem');
        $instructionSheet->setCellValue('A13', '- province_id: ID provinsi (dari tabel provinces)');
        $instructionSheet->setCellValue('A14', '- city_id: ID kabupaten/kota (dari tabel regencies)');
        $instructionSheet->setCellValue('A15', '- district_id: ID kecamatan (dari tabel districts)');
        $instructionSheet->setCellValue('A16', '- village_id: ID desa/kelurahan (dari tabel villages)');
        
        // Auto size columns to fit content
        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Set sheet name
        $sheet->setTitle('Data Siswa');
        
        // Create the directory if it doesn't exist
        if (!file_exists(storage_path('app/templates'))) {
            mkdir(storage_path('app/templates'), 0755, true);
        }
        
        // Save the file
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/templates/template_import_siswa.xlsx'));
        
        $this->info('Excel template created successfully!');
        
        return 0;
    }
}
