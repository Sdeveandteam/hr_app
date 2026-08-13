<!DOCTYPE html>
<html>
<head>
    <title>Form Absensi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-3">
    <div class="card shadow-sm mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="text-center mb-3">Form Absensi Karyawan</h4>
            <form id="absenForm" method="POST" action="/absen">
                @csrf
                <div class="mb-2">
                    <label class="form-label small text-muted">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small text-muted">Divisi</label>
                    <select name="division" class="form-select">
                        <option>IT / Engineering</option>
                        <option>Sales</option>
                        <option>HRD</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label small text-muted">Status Kehadiran</label>
                    <select name="status" class="form-select">
                        <option>Hadir (WFO)</option>
                        <option>WFH</option>
                        <option>Cuti</option>
                    </select>
                </div>

                <!-- Input GPS Tersembunyi (Otomatis Terisi) -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="photo" id="photoValue">

                <div class="mb-3">
                    <label class="form-label small text-muted">Foto Selfie</label>
                    <input type="file" name="photo_cam" accept="image/*" capture="user" class="form-control" id="cameraInput" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim Absensi Sekarang</button>
            </form>
        </div>
    </div>

    <script>
        // Otomatis deteksi GPS begitu halaman dibuka
        window.onload = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                }, function(error) {
                    alert('Gagal mendeteksi lokasi. Pastikan GPS aktif!');
                });
            } else {
                alert('Browser tidak mendukung Geolocation.');
            }
        };

        // Konversi foto ke base64 saat dipilih dari kamera
        document.getElementById('cameraInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('photoValue').value = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
