<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpPasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tersebut belum terdaftar di sistem kelas.',
            'email.email' => 'Masukkan alamat Gmail/email yang valid.',
        ]);

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_otp_codes')->where('email', $request->email)->delete();
        DB::table('password_otp_codes')->insert([
            'email' => $request->email,
            'code' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return redirect()->route('password.verify.form', ['email' => $request->email])
            ->with('status', 'Kode verifikasi 6 digit telah dikirim ke ' . $request->email);
    }

    public function showVerifyForm(Request $request)
    {
        return view('auth.verify-otp', ['email' => $request->query('email')]);
    }

    public function resetWithOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'code.digits' => 'Kode verifikasi harus 6 angka.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $record = DB::table('password_otp_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (! $record || Carbon::parse($record->expires_at)->isPast()) {
            return back()->withErrors(['code' => 'Kode verifikasi salah atau sudah kedaluwarsa.'])->withInput();
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_otp_codes')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Kata sandi berhasil diperbarui! Silakan masuk.');
    }
}