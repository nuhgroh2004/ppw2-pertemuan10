<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendMailJob;
use App\Mail\SendEmail;
use App\http\conroller\sendEmailController;
use Illuminate\Support\Facades\Storage;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya pengguna yang belum login yang dapat mengakses halaman login dan register
        $this->middleware('guest')->except([
            'logout',
            'dashboard'
        ]);
    }

    // Menampilkan halaman registrasi
    public function register()
    {
        return view('auth.register');
    }


    // Menyimpan data registrasi dan melakukan login
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:250',
        'email' => 'required|email|unique:users|max:250',
        'password' => 'required|confirmed|min:8',
        'photo' => 'image|nullable|max:2048',
        'level' => 'required|in:admin,user' // Validasi untuk level
    ]);

    // Proses upload foto
    if ($request->hasFile('photo')) {
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('photo')->storeAs('photos', $filenameSimpan);
    } else {
        $filenameSimpan = null;
    }

    // Membuat pengguna baru
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'level' => $request->level, // Menyimpan nilai level
        'password' => Hash::make($request->password),
        'photo' => $filenameSimpan
    ]);

    // Persiapkan data untuk email
    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'level' => 'admin',
        'subject' => 'Registration Confirmation'
    ];

    // Dispatch job untuk mengirim email
    dispatch(new SendMailJob($data));

    // Login otomatis setelah registrasi
    $credentials = $request->only('email', 'password');
    Auth::attempt($credentials);
    $request->session()->regenerate();

    return redirect()->route('buku.index')
        ->with('success', 'You have successfully registered and logged in. Please check your email for confirmation.');
    }

    // Menampilkan halaman login
    public function login()
    {
        return view('auth.login');
    }

    // Memproses login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Melakukan autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('buku.index')->with('success', 'You have successfully logged in');
        }

        // Jika autentikasi gagal, kembali ke halaman login
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ])->onlyInput('email');
    }

    // Menghandle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Mengarahkan kembali ke halaman buku.index setelah logout
        return redirect()->route('buku.index')->with('success', 'You have successfully logged out');
    }

    // Menampilkan halaman dashboard
    public function dashboard()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            return redirect()->route('buku.index');
        }

        // Jika belum login, arahkan ke halaman login
        return redirect()->route('login')->withErrors([
            'email' => 'Please login to access this page'
        ])->onlyInput('email');
    }
}
