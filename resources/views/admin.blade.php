<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .img-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</head>
<body class="p-3 bg-light">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Dashboard Monitoring Bos</h3>
        <a href="/" class="btn btn-outline-primary btn-sm">&larr; Kembali ke Form</a>
    </div>
    
    <div class="table-responsive card shadow-sm">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Divisi</th>
                    <th>Waktu</th>
                    <th>Lokasi (Lat, Lng)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $data)
                <tr>
                    <td>
                        @if($data->photo_path)
                            <img src="{{ asset('storage/' . $data->photo_path) }}" class="img-thumbnail rounded" alt="Foto">
                        @else
                            <span class="text-muted small">No Photo</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $data->name }}</td>
                    <td>
                        @if($data->status == 'Hadir (WFO)')
                            <span class="badge bg-success">{{ $data->status }}</span>
                        @elseif($data->status == 'WFH')
                            <span class="badge bg-info">{{ $data->status }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $data->status }}</span>
                        @endif
                    </td>
                    <td>{{ $data->division }}</td>
                    <td class="small">{{ $data->created_at->format('d M Y, H:i') }}</td>
                    <td class="small text-muted">
                        {{ $data->latitude }}, <br> {{ $data->longitude }}
                        <a href="https://www.google.com/maps?q={{ $data->latitude }},{{ $data->longitude }}" target="_blank" class="d-block small text-decoration-none">Lihat Peta</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted p-5">Belum ada data absensi hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 text-muted small text-center">Total: {{ $attendances->count() }} data</div>
</body>
</html>
