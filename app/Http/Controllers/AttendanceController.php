<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    // Tampilkan halaman form absensi
    public function index() {
        return view('attendance');
    }

    // Simpan data absensi & foto
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required|string',
            'status' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required',
        ]);

        // Simpan foto base64 dari kamera
        $img = $request->photo;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $fileName = 'photo_' . time() . '.jpg';
        Storage::disk('public')->put('uploads/' . $fileName, $data);

        // Simpan ke database
        Attendance::create([
            'name' => $request->name,
            'division' => $request->division,
            'status' => $request->status,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'photo_path' => 'uploads/' . $fileName,
        ]);

        return response()->json(['success' => true, 'message' => 'Absensi berhasil dikirim!']);
    }

    // Tampilkan data di dashboard admin
    public function admin() {
        $attendances = Attendance::latest()->get();
        return view('admin', compact('attendances'));
    }

    // Hapus data absensi
    public function destroy($id) {
        $attendance = Attendance::find($id);
        if ($attendance) {
            Storage::disk('public')->delete($attendance->photo_path);
            $attendance->delete();
        }
        return redirect()->back();
    }
};