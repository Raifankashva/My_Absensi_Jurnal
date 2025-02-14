@extends('layouts.app')

@section('title', 'Dashboard Absensi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Status Absensi Hari Ini</h2>
        
        @if($absensiHariIni)
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-gray-600">Status: 
                        <span class="font-semibold
                            @if($absensiHariIni->status === 'hadir') text-green-500
                            @elseif($absensiHariIni->status === 'telat') text-yellow-500
                            @else text-red-500 @endif">
                            {{ ucfirst($absensiHariIni->status) }}
                        </span>
                    </p>
                    <p class="text-gray-600">Jam Masuk: 
                        <span class="font-semibold">
                            {{ $absensiHariIni->jam_masuk ? $absensiHariIni->jam_masuk->format('H:i:s') : '-' }}
                        </span>
                    </p>
                    <p class="text-gray-600">Jam Keluar: 
                        <span class="font-semibold">
                            {{ $absensiHariIni->jam_keluar ? $absensiHariIni->jam_keluar->format('H:i:s') : '-' }}
                        </span>
                    </p>
                </div>
                <div>
                    @if($absensiHariIni->foto_masuk)
                        <img src="{{ Storage::url($absensiHariIni->foto_masuk) }}" 
                             alt="Foto Masuk" 
                             class="w-32 h-32 object-cover rounded">
                    @endif
                </div>
            </div>
        @else
            <p class="text-gray-600 mb-4">Anda belum melakukan absensi hari ini</p>
        @endif

        @if(!$absensiHariIni)
            <button onclick="showScannerModal()" 
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Scan QR untuk Absen Masuk
            </button>
        @elseif(!$absensiHariIni->jam_keluar)
            <button onclick="showCheckoutModal()" 
                    class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                Absen Pulang
            </button>
        @else
            <p class="text-green-500 font-semibold">Absensi hari ini sudah lengkap</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Riwayat Absensi</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Keluar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($riwayatAbsensi as $absensi)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($absensi->status === 'hadir') bg-green-100 text-green-800
                                @elseif($absensi->status === 'telat') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->jam_masuk ? $absensi->jam_masuk->format('H:i:s') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $absensi->jam_keluar ? $absensi->jam_keluar->format('H:i:s') : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $riwayatAbsensi->links() }}
    </div>
</div>

<!-- Modal Scanner QR -->
<div id="scannerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Scan QR Code</h3>
            <div class="mt-2 px-7 py-3">
                <div id="qr-reader" class="w-full"></div>
                <div id="qr-reader-results"></div>
            </div>
            <div class="mt-4">
                <button onclick="closeScannerModal()" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Checkout -->
<div id="checkoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Absen Pulang</h3>
            <div class="mt-2 px-7 py-3">
                <form id="checkoutForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Foto</label>
                        <input type="file" 
                               accept="image/*" 
                               capture="camera" 
                               id="checkout-photo" 
                               class="mt-1 block w-full" 
                               required>
                    </div>
                    <input type="hidden" id="checkout-location" name="location">
                    <button type="submit" 
                            class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Submit
                    </button>
                </form>
            </div>
            <div class="mt-4">
                <button onclick="closeCheckoutModal()" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<script>
let html5QrcodeScanner;

function showScannerModal() {
    document.getElementById('scannerModal').classList.remove('hidden');
    initializeScanner();
}

function closeScannerModal() {
    document.getElementById('scannerModal').classList.add('hidden');
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
    }
}

function initializeScanner() {
    html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 }
    );
    
    html5QrcodeScanner.render(onScanSuccess, onScanError);
}

function onScanSuccess(qrCodeMessage) {
    // Get location
    navigator.geolocation.getCurrentPosition((position) => {
        const location = `${position.coords.latitude},${position.coords.longitude}`;
        
        // Get photo
        const photoInput = document.createElement('input');
        photoInput.type = 'file';
        photoInput.accept = 'image/*';
        photoInput.capture = 'camera';
        
        photoInput.onchange = (e) => {
            const photo = e.target.files[0];
            
            const formData = new FormData();
            formData.append('foto_masuk', photo);
            formData.append('lokasi_masuk', location);
            formData.append('qr_code', qrCodeMessage);
            
            axios.post('/api/absensi/check-in', formData)
                .then(response => {
                    alert('Absen masuk berhasil!');
                    location.reload();
                })
                .catch(error => {
                    alert(error.response.data.message || 'Terjadi kesalahan');
                });
        };
        
        photoInput.click();
    });
}

function onScanError(error) {
    console.warn(`QR error: ${error}`);
}

function showCheckoutModal() {
    document.getElementById('checkoutModal').classList.remove('hidden');
    
    // Get location
    navigator.geolocation.getCurrentPosition((position) => {
        document.getElementById('checkout-location').value = 
            `${position.coords.latitude},${position.coords.longitude}`;
    });
}

function closeCheckoutModal() {
    document.getElementById('checkoutModal').classList.add('hidden');
}

document.getElementById('checkoutForm').onsubmit = function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('foto_keluar', document.getElementById('checkout-photo').files[0]);
    formData.append('lokasi_keluar', document.getElementById('checkout-location').value);
    formData.append('token', '{{ $absensiHariIni ? $absensiHariIni->token : "" }}');
    
    axios.post('/api/absensi/check-out', formData)
        .then(response => {
            alert('Absen keluar berhasil!');
            location.reload();
        })
        .catch(error => {
            alert(error.response.data.message || 'Terjadi kesalahan');
        });
};
</script>
@endsection