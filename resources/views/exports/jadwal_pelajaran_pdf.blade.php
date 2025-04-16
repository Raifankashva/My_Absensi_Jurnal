<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Jadwal Pelajaran</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #1f2937;
            background-color: white;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eef2ff;
        }

        .header h2 {
            color: #4f46e5;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #374151;
            margin-bottom: 10px;
        }

        .header h3 {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 16px;
            margin-top: 10px;
        }

        .filter-info {
            margin-bottom: 25px;
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
        }

        .filter-table {
            width: 100%;
            border: none;
        }

        .filter-table td {
            border: none;
            padding: 5px 10px;
        }

        .filter-label {
            font-weight: bold;
            width: 100px;
            color: #374151;
        }

        .filter-value {
            color: #4f46e5;
            font-weight: 500;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .schedule-table th, 
        .schedule-table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }

        .schedule-table th {
            background-color: #4f46e5;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .schedule-table tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        .schedule-table tr:hover {
            background-color: #eef2ff;
        }

        .subject-cell {
            font-weight: 600;
            color: #111827;
        }

        .time-cell {
            color: #f97316;
            font-weight: 500;
        }

        .day-cell {
            position: relative;
        }

        .day-cell::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
            background-color: #4f46e5;
        }

        .day-senin::before { background-color: #4f46e5; }
        .day-selasa::before { background-color: #f97316; }
        .day-rabu::before { background-color: #10b981; }
        .day-kamis::before { background-color: #8b5cf6; }
        .day-jumat::before { background-color: #ec4899; }
        .day-sabtu::before { background-color: #ef4444; }

        .footer {
            text-align: right;
            margin-top: 30px;
            font-size: 12px;
            color: #374151;
            font-style: italic;
        }

        .print-button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
            cursor: pointer;
            border: none;
            font-family: inherit;
            font-size: 14px;
        }

        .print-button:hover {
            background-color: #4338ca;
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 12px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }

        @media print {
            body {
                padding: 0;
                background-color: white;
            }
            
            .container {
                box-shadow: none;
                padding: 0;
            }
            
            .print-button, .no-print {
                display: none;
            }
            
            .schedule-table {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ $sekolah->nama_sekolah }}</h2>
            <p>{{ $sekolah->alamat }}</p>
            <h3>JADWAL PELAJARAN</h3>
        </div>
        
        <div class="filter-info">
            <table class="filter-table">
                <tr>
                    <td class="filter-label">Kelas</td>
                    <td class="filter-value">: {{ $filterKelas }}</td>
                </tr>
                <tr>
                    <td class="filter-label">Hari</td>
                    <td class="filter-value">: {{ $filterHari }}</td>
                </tr>
                <tr>
                    <td class="filter-label">Guru</td>
                    <td class="filter-value">: {{ $filterGuru }}</td>
                </tr>
            </table>
        </div>
        
        <div class="legend no-print">
            <div class="legend-item"><span class="legend-color" style="background-color: #4f46e5;"></span> Senin</div>
            <div class="legend-item"><span class="legend-color" style="background-color: #f97316;"></span> Selasa</div>
            <div class="legend-item"><span class="legend-color" style="background-color: #10b981;"></span> Rabu</div>
            <div class="legend-item"><span class="legend-color" style="background-color: #8b5cf6;"></span> Kamis</div>
            <div class="legend-item"><span class="legend-color" style="background-color: #ec4899;"></span> Jumat</div>
            <div class="legend-item"><span class="legend-color" style="background-color: #ef4444;"></span> Sabtu</div>
        </div>
        
        <table class="schedule-table" id="jadwal-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($jadwalPelajaran as $jadwal)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $jadwal->kelas->nama_kelas }}</td>
                    <td class="subject-cell">{{ $jadwal->mata_pelajaran }}</td>
                    <td>{{ $jadwal->guru->nama_lengkap }}</td>
                    <td class="day-cell day-{{ strtolower($jadwal->hari) }}">{{ $jadwal->hari }}</td>
                    <td class="time-cell">{{ $jadwal->jam_mulai }}</td>
                    <td class="time-cell">{{ $jadwal->jam_selesai }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="footer">
            <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        // Add sorting functionality
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.schedule-table th').forEach((header, index) => {
                if (index === 0) return; // Skip the "No" column
                
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    sortTable(index);
                });
            });
        });

        function sortTable(columnIndex) {
            const table = document.getElementById('jadwal-table');
            let switching = true;
            let shouldSwitch, rows, i;
            let switchCount = 0;
            let direction = "asc";
            
            while (switching) {
                switching = false;
                rows = table.rows;
                
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    const x = rows[i].getElementsByTagName("TD")[columnIndex];
                    const y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                    
                    if (direction === "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (direction === "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchCount++;
                } else {
                    if (switchCount === 0 && direction === "asc") {
                        direction = "desc";
                        switching = true;
                    }
                }
            }
            
            // Update row numbers
            for (i = 1; i < table.rows.length; i++) {
                table.rows[i].cells[0].textContent = i;
            }
        }
    </script>
</body>
</html>