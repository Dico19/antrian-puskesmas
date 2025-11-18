<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;   // <- tambahkan ini

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // 1. VALIDASI INPUT
        $data = $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // 2. EMAIL TUJUAN (ADMIN) - ganti kalau mau ke email lain
        $adminEmail = 'puskesmaskaligandu@gmail.com';

        // 3. KIRIM EMAIL
        Mail::send('emails.contact', ['data' => $data], function ($message) use ($data, $adminEmail) {
            $message->to($adminEmail)
                    ->subject('Pesan Baru dari Form Contact: ' . $data['subject'])
                    ->replyTo($data['email'], $data['name']);
        });

        // 4. BALIK KE HALAMAN CONTACT DENGAN PESAN SUKSES
        return back()->with('success', 'Pesan kamu berhasil dikirim!');
    }
}
