@extends('layouts.public')

@section('title', 'Certificate Verification - Padmabati Computer Academy')

@section('content')
<div class="pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Certificate <span class="text-amber-400">Verification</span>
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Verify the authenticity of certificates issued by Padmabati Computer Academy
            </p>
        </div>

        @if($verified)
            <!-- Verified Certificate -->
            <div class="bg-white/5 border border-green-500/30 rounded-2xl p-8 mb-8">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-green-400 text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-green-400 mb-2">Certificate Verified!</h2>
                    <p class="text-gray-300">{{ $message }}</p>
                </div>

                <!-- Certificate Details -->
                <div class="bg-white/10 border border-white/20 rounded-xl p-6">
                    <h3 class="text-white font-bold text-lg mb-6">Certificate Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Student Name</label>
                                <p class="text-white font-medium">{{ $certificate->student->user->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Course</label>
                                <p class="text-white font-medium">{{ $certificate->course->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Certificate Number</label>
                                <p class="text-amber-400 font-mono">{{ $certificate->certificate_number }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Issue Date</label>
                                <p class="text-white">{{ $certificate->issued_at->format('F j, Y') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Grade</label>
                                <p class="text-white">
                                    @if($certificate->grade)
                                        <span class="inline-flex items-center px-2 py-1 bg-amber-500/20 text-amber-400 rounded-full text-sm">
                                            {{ strtoupper($certificate->grade) }}
                                        </span>
                                    @else
                                        Completed
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-gray-400 text-sm mb-1">Issued By</label>
                                <p class="text-white">{{ $certificate->issuer->name ?? 'Padmabati Computer Academy' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Certificate Info -->
                    @if($certificate->template_data)
                        <div class="mt-6 pt-6 border-t border-white/10">
                            <h4 class="text-white font-semibold mb-3">Additional Information</h4>
                            <div class="text-gray-300 text-sm">
                                @foreach($certificate->template_data as $key => $value)
                                    @if(is_string($value) || is_numeric($value))
                                        <div class="flex justify-between py-1">
                                            <span class="text-gray-400">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                            <span>{{ $value }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Verification Badges -->
                    <div class="mt-6 pt-6 border-t border-white/10">
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Verified Authentic
                            </span>
                            <span class="inline-flex items-center px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm">
                                <i class="fas fa-award mr-1"></i>
                                Official Certificate
                            </span>
                            <span class="inline-flex items-center px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm">
                                <i class="fas fa-lock mr-1"></i>
                                Blockchain Secured
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Invalid Certificate -->
            <div class="bg-white/5 border border-red-500/30 rounded-2xl p-8 mb-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-red-400 text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-red-400 mb-2">Certificate Not Found</h2>
                    <p class="text-gray-300 mb-6">{{ $message }}</p>
                    
                    <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4 text-left">
                        <h3 class="text-red-400 font-semibold mb-2">Possible Reasons:</h3>
                        <ul class="list-disc list-inside text-sm text-gray-300 space-y-1">
                            <li>The QR code or verification link may be damaged or corrupted</li>
                            <li>The certificate may have been revoked or expired</li>
                            <li>The verification token may be invalid or tampered with</li>
                            <li>The certificate may not be issued by Padmabati Computer Academy</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Verification Process Info -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6">How Certificate Verification Works</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-amber-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-amber-400 font-bold">1</span>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Scan QR Code</h3>
                    <p class="text-gray-400 text-sm">Scan the QR code printed on the certificate using any QR code reader</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-teal-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-teal-400 font-bold">2</span>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Access This Page</h3>
                    <p class="text-gray-400 text-sm">The QR code will redirect you to this verification page automatically</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-purple-400 font-bold">3</span>
                    </div>
                    <h3 class="text-white font-semibold mb-2">View Results</h3>
                    <p class="text-gray-400 text-sm">See the verification status and certificate details instantly</p>
                </div>
            </div>
        </div>

        <!-- Manual Verification -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6">Manual Verification</h2>
            <p class="text-gray-400 mb-6">
                If you have a certificate number and want to verify it manually, you can contact us directly.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white/10 rounded-lg p-4">
                    <h3 class="text-white font-semibold mb-3">Contact Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-phone text-amber-500 w-5"></i>
                            <span class="text-gray-300">+91 98765 43210</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-teal-500 w-5"></i>
                            <span class="text-gray-300">verify@padmabatiacademy.com</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-purple-500 w-5"></i>
                            <span class="text-gray-300">Mon-Sat: 9 AM - 6 PM</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white/10 rounded-lg p-4">
                    <h3 class="text-white font-semibold mb-3">Required Information</h3>
                    <ul class="list-disc list-inside text-sm text-gray-300 space-y-1">
                        <li>Certificate Number</li>
                        <li>Student Name</li>
                        <li>Course Name</li>
                        <li>Issue Date (if available)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="bg-gradient-to-r from-amber-500/20 to-red-500/20 border border-amber-500/30 rounded-2xl p-8 text-center">
            <h2 class="text-white text-2xl font-bold mb-4">Security Notice</h2>
            <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                All certificates issued by Padmabati Computer Academy are protected with advanced security features. 
                If you suspect a fraudulent certificate, please report it to us immediately.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Report Fraud
                </a>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 border border-amber-500 text-amber-400 hover:bg-amber-500 hover:text-white font-medium rounded-lg transition">
                    <i class="fas fa-home mr-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection