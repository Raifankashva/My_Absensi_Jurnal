<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi Siswa</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #1e40af;
            --accent-color: #dbeafe;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
            --header-bg: #f9fafb;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: var(--text-color);
            background-color: #fff;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
            position: relative;
        }
        
        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background-color: var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .header h2 {
            color: var(--primary-color);
            font-size: 24px;
            margin: 5px 0;
        }
        
        .header h3 {
            font-size: 18px;
            margin: 5px 0;
            color: var(--secondary-color);
        }
        
        .header p {
            font-size: 14px;
            color: #6b7280;
            margin-top: 10px;
        }
        
        .actions {
            margin: 20px 0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-outline {
            background-color: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }
        
        .btn-outline:hover {
            background-color: var(--accent-color);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 12px;
        }
        
        table, th, td {
            border: 1px solid var(--border-color);
        }
        
        th, td {
            padding: 10px;
            text-align: center;
        }
        
        th {
            background-color: var(--header-bg);
            color: var(--secondary-color);
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tbody tr:hover {
            background-color: var(--accent-color);
        }
        
        .summary {
            margin: 30px 0;
            padding: 20px;
            background-color: var(--header-bg);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }
        
        .summary h4 {
            color: var(--secondary-color);
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .summary-item {
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .summary-item p {
            margin: 0;
            font-size: 13px;
        }
        
        .summary-item .value {
            font-size: 18px;
            font-weight: bold;
            color: var(--primary-color);
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: right;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }
        
        .signature {
            margin-top: 20px;
        }
        
        .signature p:first-child {
            margin-bottom: 60px;
        }
        
        .signature p:last-child {
            border-top: 1px solid var(--border-color);
            padding-top: 5px;
            display: inline-block;
            min-width: 200px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .attendance-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            justify-content: center;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
        }
        
        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }
        
        .color-hadir { background-color: #10b981; }
        .color-terlambat { background-color: #f59e0b; }
        .color-sakit { background-color: #3b82f6; }
        .color-izin { background-color: #8b5cf6; }
        .color-alpa { background-color: #ef4444; }
        
        /* Print styles */
        @media print {
            body {
                padding: 0;
                background-color: white;
            }
            
            .container {
                box-shadow: none;
                padding: 10px;
            }
            
            .actions, .no-print {
                display: none !important;
            }
            
            .header, .footer, .summary {
                break-inside: avoid;
            }
            
            table {
                font-size: 10px;
            }
            
            th, td {
                padding: 5px;
            }
            
            .page-break {
                page-break-after: always;
            }
        }
        
        /* Loading indicator */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loading">
        <div class="spinner"></div>
    </div>

    <div class="container" id="report-container">
        <div class="header">
            <div class="logo-container">
                <div class="logo">LOGO</div>
                <div class="actions no-print">
                    <button class="btn btn-outline" onclick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                        Cetak
                    </button>
                    <button class="btn" onclick="generatePDF()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2z"/>
                            <path d="M3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h7v1a1 1 0 0 1-1 1H6zm7-3H6v-2h7v2z"/>
                        </svg>
                        Unduh PDF
                    </button>
                </div>
            </div>
            <h2>LAPORAN KEHADIRAN SISWA</h2>
            <h3>{{ $sekolah->nama_sekolah }}</h3>
            <p>Periode: {{ $periodLabel }}</p>
        </div>

        <div class="attendance-legend">
            <div class="legend-item">
                <div class="legend-color color-hadir"></div>
                <span>Hadir</span>
            </div>
            <div class="legend-item">
                <div class="legend-color color-terlambat"></div>
                <span>Terlambat</span>
            </div>
            <div class="legend-item">
                <div class="legend-color color-sakit"></div>
                <span>Sakit</span>
            </div>
            <div class="legend-item">
                <div class="legend-color color-izin"></div>
                <span>Izin</span>
            </div>
            <div class="legend-item">
                <div class="legend-color color-alpa"></div>
                <span>Alpa</span>
            </div>
        </div>

        <table id="attendance-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Hadir</th>
                    <th>Terlambat</th>
                    <th>Sakit</th>
                    <th>Izin</th>
                    <th>Alpa</th>
                    <th>Tidak Ada Data</th>
                    <th>Total Hari</th>
                    <th>% Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @if(count($statistics) > 0)
                    @foreach($statistics as $index => $stat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $stat['siswa']->nisn }}</td>
                            <td>{{ $stat['siswa']->nama_lengkap }}</td>
                            <td>{{ $stat['siswa']->kelas->nama_kelas ?? 'Tidak ada kelas' }}</td>
                            <td>{{ $stat['hadir'] }}</td>
                            <td>{{ $stat['terlambat'] }}</td>
                            <td>{{ $stat['sakit'] }}</td>
                            <td>{{ $stat['izin'] }}</td>
                            <td>{{ $stat['alpa'] }}</td>
                            <td>{{ $stat['tidak_ada'] }}</td>
                            <td>{{ $stat['total_hari_sekolah'] }}</td>
                            <td>
                                @php
                                    $totalKehadiran = $stat['hadir'] + $stat['terlambat'];
                                    $persentase = $stat['total_hari_sekolah'] > 0 
                                        ? round(($totalKehadiran / $stat['total_hari_sekolah']) * 100, 2)
                                        : 0;
                                @endphp
                                {{ $persentase }}%
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="summary">
            <h4>Ringkasan Kehadiran:</h4>
            @php
                $totalSiswa = count($statistics);
                $totalHadir = array_sum(array_column($statistics, 'hadir'));
                $totalTerlambat = array_sum(array_column($statistics, 'terlambat'));
                $totalSakit = array_sum(array_column($statistics, 'sakit'));
                $totalIzin = array_sum(array_column($statistics, 'izin'));
                $totalAlpa = array_sum(array_column($statistics, 'alpa'));
                
                $avgHadir = $totalSiswa > 0 ? round($totalHadir / $totalSiswa, 2) : 0;
                $avgTerlambat = $totalSiswa > 0 ? round($totalTerlambat / $totalSiswa, 2) : 0;
                $avgSakit = $totalSiswa > 0 ? round($totalSakit / $totalSiswa, 2) : 0;
                $avgIzin = $totalSiswa > 0 ? round($totalIzin / $totalSiswa, 2) : 0;
                $avgAlpa = $totalSiswa > 0 ? round($totalAlpa / $totalSiswa, 2) : 0;
            @endphp
            
            <div class="summary-grid">
                <div class="summary-item">
                    <p>Jumlah Siswa</p>
                    <div class="value">{{ $totalSiswa }}</div>
                </div>
                <div class="summary-item">
                    <p>Total Hadir</p>
                    <div class="value">{{ $totalHadir }}</div>
                    <p>Rata-rata: {{ $avgHadir }} per siswa</p>
                </div>
                <div class="summary-item">
                    <p>Total Terlambat</p>
                    <div class="value">{{ $totalTerlambat }}</div>
                    <p>Rata-rata: {{ $avgTerlambat }} per siswa</p>
                </div>
                <div class="summary-item">
                    <p>Total Sakit</p>
                    <div class="value">{{ $totalSakit }}</div>
                    <p>Rata-rata: {{ $avgSakit }} per siswa</p>
                </div>
                <div class="summary-item">
                    <p>Total Izin</p>
                    <div class="value">{{ $totalIzin }}</div>
                    <p>Rata-rata: {{ $avgIzin }} per siswa</p>
                </div>
                <div class="summary-item">
                    <p>Total Alpa</p>
                    <div class="value">{{ $totalAlpa }}</div>
                    <p>Rata-rata: {{ $avgAlpa }} per siswa</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Dicetak pada: {{ Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>
            <div class="signature">
                <p>Kepala Sekolah</p>
                <p>({{ $sekolah->kepala_sekolah ?? '........................' }})</p>
            </div>
        </div>
    </div>

    <script>
        // Sort table functionality
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('attendance-table');
            const headers = table.querySelectorAll('th');
            
            headers.forEach((header, index) => {
                if (index > 0) { // Skip the "No" column
                    header.addEventListener('click', () => {
                        sortTable(index);
                    });
                    header.style.cursor = 'pointer';
                    header.title = 'Klik untuk mengurutkan';
                }
            });
            
            function sortTable(columnIndex) {
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                // Skip if there's no data
                if (rows.length <= 1 || rows[0].querySelector('td').colSpan) return;
                
                const direction = headers[columnIndex].classList.contains('sort-asc') ? -1 : 1;
                
                // Reset all headers
                headers.forEach(h => {
                    h.classList.remove('sort-asc', 'sort-desc');
                });
                
                // Set new sort direction
                headers[columnIndex].classList.add(direction === 1 ? 'sort-asc' : 'sort-desc');
                
                // Sort the rows
                rows.sort((a, b) => {
                    let aValue = a.querySelectorAll('td')[columnIndex].textContent.trim();
                    let bValue = b.querySelectorAll('td')[columnIndex].textContent.trim();
                    
                    // Handle percentage values
                    if (aValue.endsWith('%')) {
                        aValue = parseFloat(aValue);
                        bValue = parseFloat(bValue);
                    }
                    // Handle numeric values
                    else if (!isNaN(aValue) && !isNaN(bValue)) {
                        aValue = parseFloat(aValue);
                        bValue = parseFloat(bValue);
                    }
                    
                    if (aValue < bValue) return -1 * direction;
                    if (aValue > bValue) return 1 * direction;
                    return 0;
                });
                
                // Reorder the rows
                rows.forEach(row => tbody.appendChild(row));
                
                // Update row numbers
                rows.forEach((row, index) => {
                    row.querySelectorAll('td')[0].textContent = index + 1;
                });
            }
        });
        
        // PDF generation
        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const element = document.getElementById('report-container');
            const loading = document.querySelector('.loading');
            
            // Show loading indicator
            loading.style.display = 'flex';
            
            // Remove actions temporarily
            const actions = document.querySelector('.actions');
            const actionsDisplay = actions.style.display;
            actions.style.display = 'none';
            
            // Set a timeout to allow the DOM to update
            setTimeout(() => {
                html2canvas(element, {
                    scale: 2,
                    useCORS: true,
                    logging: false
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF('p', 'mm', 'a4');
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = pdf.internal.pageSize.getHeight();
                    const imgWidth = canvas.width;
                    const imgHeight = canvas.height;
                    const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                    const imgX = (pdfWidth - imgWidth * ratio) / 2;
                    const imgY = 0;
                    
                    pdf.addImage(imgData, 'PNG', imgX, imgY, imgWidth * ratio, imgHeight * ratio);
                    pdf.save('laporan-kehadiran-siswa.pdf');
                    
                    // Restore actions display
                    actions.style.display = actionsDisplay;
                    
                    // Hide loading indicator
                    loading.style.display = 'none';
                });
            }, 100);
        }
        
        // Highlight cells based on values
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('attendance-table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 1) { // Skip "no data" row
                    // Highlight percentage cell
                    const percentCell = cells[11];
                    const percentValue = parseFloat(percentCell.textContent);
                    if (percentValue < 70) {
                        percentCell.style.backgroundColor = '#fee2e2';
                        percentCell.style.color = '#b91c1c';
                        percentCell.style.fontWeight = 'bold';
                    } else if (percentValue >= 90) {
                        percentCell.style.backgroundColor = '#d1fae5';
                        percentCell.style.color = '#047857';
                        percentCell.style.fontWeight = 'bold';
                    }
                    
                    // Highlight alpa cell
                    const alpaCell = cells[8];
                    const alpaValue = parseInt(alpaCell.textContent);
                    if (alpaValue > 0) {
                        alpaCell.style.backgroundColor = '#fee2e2';
                        alpaCell.style.color = '#b91c1c';
                        alpaCell.style.fontWeight = 'bold';
                    }
                }
            });
        });
    </script>
</body>
</html>