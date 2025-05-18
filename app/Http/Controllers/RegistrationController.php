<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'parent_name' => 'required|string|max:255',
            'child_name' => 'required|string|max:255',
            'grade' => 'required|string|in:PAUD,TK,SD1-3,SD4-6',
            'phone' => 'required|string|regex:/^[0-9]{10,13}$/',
            'message' => 'nullable|string|max:1000',
        ]);

        try {
            // Simpan data pendaftaran
            $registration = Registration::create([
                'parent_name' => $request->parent_name,
                'child_name' => $request->child_name,
                'grade' => $request->grade,
                'phone' => $request->phone,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            // Kirim notifikasi ke admin (bisa ditambahkan nanti)
            // Mail::to('admin@bimbelalfarizqi.com')->send(new NewRegistration($registration));

            return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Kami akan menghubungi Anda segera.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami melalui WhatsApp.')
                ->withInput();
        }
    }
} 
 
 
 
 