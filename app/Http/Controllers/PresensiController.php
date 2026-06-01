<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Storage;
use Illuminate\Support\Facades\Hash;


class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $latidutekantor = -0.927267682069316; //(-0.9477627932817836, 100.3653570927499 - REC) (-0.9481435706460654, 100.36506879609117 - parkiran) (-0.9226262070500596, 100.36013623143776 - kampus) (-0.927267682069316, 100.35680311316776 - rumah)
        $longitudekantor = 100.35680311316776;
        $lokasi = $request->lokasi;
        // dd($lokasi);
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latidutekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak['meters']);
        // dd($radius);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "uploads/absensi/";
        $formatName = $nik . '-' . $tgl_presensi . '-' . date('His') . '-' . $ket;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;


        if ($radius > 40) {
            echo "error|Maaf, Anda Berada Diluar Area Radius Kantor|radius";
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if ($update) {
                    echo "success|Terimakasih, Hati hati Di Jalan|out";
                    Storage::disk('public')->put($file, $image_base64);
                } else {
                    echo "error|Maaf Absen Gagal, Hubungi Admin|out";
                }
            } else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    Storage::disk('public')->put($file, $image_base64);
                    echo "success|Terimakasih, Selamat Bekerja|in";
                } else {
                    echo "error|Maaf Absen Gagal, Hubungi Admin|in";
                }
            }
        }

    }
    // menghitung jarak antara dua titik koordinat
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();

        if ($request->hasFile('foto')) {
            $foto = $nik . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('uploads/karyawan', $foto, 'public');
        } else {
            $foto = $karyawan->foto;
        }

        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        } else {
            $request->validate([
                'password' => [
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/[A-Z]/',       // huruf besar
                    'regex:/[0-9]/',       // angka
                    'regex:/[@$!%*#?&]/'   // simbol
                ]
            ], [
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'password.min' => 'Password minimal 8 karakter',
                'password.regex' => 'Password harus mengandung huruf besar, angka, dan simbol (!@#$%&*?&)',
            ]);

            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => Hash::make($request->password),
                'foto' => $foto
            ];
        }


        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = public_path('uploads/karyawan');
                $request->file('foto')->move($folderPath, $foto);

            }
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('presensi.izin', compact('dataizin'));
    }

    public function buatizin()
    {
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan,
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'Izin Berhasil Diajukan']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Izin Gagal Diajukan']);
        }
    }
}
