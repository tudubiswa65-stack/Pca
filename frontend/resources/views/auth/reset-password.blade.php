@extends('layouts.public')

@section('title', 'Reset Password - Padmabati Computer Academy')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-navy-900 mb-2">Reset Password</h1>
            <p class="text-gray-600">Enter OTP and your new password</p>
            <p class="text-sm text-gray-500">for {{ $phone ?? 'your account' }}</p>
        </div>

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('password.reset') }}" x-data="resetPasswordForm()">
            @csrf
            
            <!-- OTP Field -->
            <div class="mb-6">
                <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-mobile-alt mr-1"></i>
                    6-Digit OTP
                </label>
                <input 
                    type="text" 
                    id="otp" 
                    name="otp" 
                    x-model="otp"
                    @input="validateOtp()"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 text-center text-lg font-mono"
                    placeholder="Enter 6-digit OTP"
                    maxlength="6"
                    required
                >
                @error('otp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="otpError" x-text="otpError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <!-- New Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1"></i>
                    New Password
                </label>
                <div class="relative">
                    <input 
                        :type="showPassword ? 'text' : 'password'"
                        id="password" 
                        name="password"
                        x-model="password"
                        @input="validatePassword()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 pr-12"
                        placeholder="Enter your new password"
                        required
                    >
                    <button 
                        type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    >
                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="passwordError" x-text="passwordError" class="text-red-500 text-sm mt-1"></p>
                <div x-show="password.length > 0" class="mt-2 space-y-1">
                    <div class="flex items-center text-xs">
                        <i :class="password.length >= 8 ? 'fas fa-check text-green-600' : 'fas fa-times text-red-500'" class="mr-1"></i>
                        <span :class="password.length >= 8 ? 'text-green-600' : 'text-red-500'">At least 8 characters</span>
                    </div>
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1"></i>
                    Confirm New Password
                </label>
                <div class="relative">
                    <input 
                        :type="showConfirmPassword ? 'text' : 'password'"
                        id="password_confirmation" 
                        name="password_confirmation"
                        x-model="passwordConfirmation"
                        @input="validatePasswordConfirmation()"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 pr-12"
                        placeholder="Confirm your new password"
                        required
                    >
                    <button 
                        type="button" 
                        @click="showConfirmPassword = !showConfirmPassword"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    >
                        <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="passwordConfirmationError" x-text="passwordConfirmationError" class="text-red-500 text-sm mt-1"></p>
                <p x-show="passwordConfirmation.length > 0 && password === passwordConfirmation" class="text-green-600 text-sm mt-1">
                    <i class="fas fa-check mr-1"></i>
                    Passwords match
                </p>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                :disabled="!isValid || submitting"
                class="w-full bg-gradient-to-r from-green-500 to-teal-500 text-white font-semibold py-3 px-4 rounded-xl hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span x-show="!submitting">
                    <i class="fas fa-check mr-2"></i>
                    Reset Password
                </span>
                <span x-show="submitting" class="flex items-center justify-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Resetting Password...
                </span>
            </button>
        </form>

        <!-- Security Notice -->
        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
            <div class="flex">
                <i class="fas fa-shield-alt text-amber-500 mt-0.5 mr-3"></i>
                <div class="text-sm text-amber-800">
                    <p class="font-semibold">Security Tip:</p>
                    <p>Choose a strong password with a mix of letters, numbers, and symbols.</p>
                </div>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Login
            </a>
        </div>
    </div>
</div>

<script>
function resetPasswordForm() {
    return {
        otp: '',
        password: '',
        passwordConfirmation: '',
        showPassword: false,
        showConfirmPassword: false,
        submitting: false,
        otpError: '',
        passwordError: '',
        passwordConfirmationError: '',
        
        get isValid() {
            return this.otp.length === 6 && 
                   this.password.length >= 8 && 
                   this.password === this.passwordConfirmation &&
                   !this.otpError && !this.passwordError && !this.passwordConfirmationError;
        },
        
        validateOtp() {
            this.otpError = '';
            if (this.otp.length > 0 && !/^\d{6}$/.test(this.otp)) {
                this.otpError = 'OTP must be exactly 6 digits';
            }
        },
        
        validatePassword() {
            this.passwordError = '';
            if (this.password.length > 0 && this.password.length < 8) {
                this.passwordError = 'Password must be at least 8 characters';
            }
            this.validatePasswordConfirmation();
        },
        
        validatePasswordConfirmation() {
            this.passwordConfirmationError = '';
            if (this.passwordConfirmation.length > 0 && this.password !== this.passwordConfirmation) {
                this.passwordConfirmationError = 'Passwords do not match';
            }
        }
    }
}
</script>
@endsection