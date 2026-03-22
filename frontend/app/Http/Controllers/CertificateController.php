<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function verify(string $qrToken)
    {
        $certificate = Certificate::with(['student.user', 'course', 'issuer'])
                                 ->where('qr_token', $qrToken)
                                 ->first();

        if (!$certificate) {
            return view('public.certificate-verify', [
                'verified' => false,
                'message' => 'Certificate not found or invalid verification token.'
            ]);
        }

        return view('public.certificate-verify', [
            'verified' => true,
            'certificate' => $certificate,
            'message' => 'Certificate verified successfully!'
        ]);
    }
}