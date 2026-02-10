<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;




class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if (Auth::guard('karyawan')->attempt(['nik' => $request->nik, 'password' => $request->password])) {
            return redirect('/dashboard');
        } else {
            return redirect('/')->with(['warning' => 'NIK atau Password salah!']);
        }
    }

    public function proseslogout()
    {
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
            return redirect('/');
        } else {

        }
    }

    // Tampilkan halaman register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses penyimpanan data register
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nik' => 'required|unique:karyawan,nik|min:16',
            'gender' => 'required|in:0,1',
            'jabatan' => 'required',
            'no_hp' => 'required|min:10|max:13',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',      // Wajib ada huruf besar
                'regex:/[0-9]/',      // Wajib ada angka
                'regex:/[@$!%*#?&]/'  // Wajib ada simbol
            ],
            'password_confirmation' => 'required'
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nik.unique' => 'NIK sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf besar, angka, dan simbol (!@#$%&*?&)',
            'nik.min'=> 'NIK belum 16 karakter',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'gender.in' => 'Jenis kelamin tidak ada',
            'jabatan.required' => 'Jabatan harus diisi',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.min' => 'No HP minimal 10 karakter',
            'no_hp.max' => 'No HP maksimal 13 karakter',
        ]);


        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'password' => bcrypt($request->password),
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads/karyawan', $filename);
            $data['foto'] = $filename;
        }

        \App\Models\Karyawan::create($data);

        return redirect('/')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // Tampilkan form lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function processForgotPassword(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'no_hp' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',      // Wajib ada huruf besar
                'regex:/[0-9]/',      // Wajib ada angka
                'regex:/[@$!%*#?&]/'  // Wajib ada simbol
            ],
            'password_confirmation' => 'required'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf besar, angka, dan simbol (!@#$%&*?&)',
        ]);

        $karyawan = \App\Models\Karyawan::where('nik', $request->nik)
            ->where('no_hp', $request->no_hp)
            ->first();

        if (!$karyawan) {
            return back()->with('warning', 'NIK atau No HP tidak sesuai.');
        }

        $karyawan->password = Hash::make($request->password);
        $karyawan->save();

        Session::regenerateToken();
        return redirect('/')->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');

    }


}
