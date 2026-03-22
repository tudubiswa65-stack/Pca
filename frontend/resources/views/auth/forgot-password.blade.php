@extends('layouts.public')

@section('title', 'Forgot Password - Padmabati Computer Academy')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-unlock-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-navy-900 mb-2">Forgot Password?</h1>
            <p class="text-gray-600">Enter your phone number to receive an OTP</p>
        </div>

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}" x-data="forgotPasswordForm()">
            @csrf
            
            <!-- Phone Field -->
            <div class="mb-6">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-phone mr-1"></i>
                    Phone Number
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}"
                    x-model="phone"
                    @input="validatePhone()"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200"
                    placeholder="Enter your 10-digit phone number"
                    maxlength="10"
                    required
                >
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p x-show="phoneError" x-text="phoneError" class="text-red-500 text-sm mt-1"></p>
                <p x-show="phoneSuccess" class="text-teal-600 text-sm mt-1">
                    <i class="fas fa-check mr-1"></i>
                    Valid phone number
                </p>
            </div>

            <!-- Info Message -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">How it works:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Enter your registered phone number</li>
                            <li>We'll send you a 6-digit OTP</li>
                            <li>Enter the OTP and set a new password</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                :disabled="!isValid || submitting"
                class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold py-3 px-4 rounded-xl hover:from-orange-600 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span x-show="!submitting">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send OTP
                </span>
                <span x-show="submitting" class="flex items-center justify-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Sending OTP...
                </span>
            </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center">
            <div class="flex-1 border-t border-gray-300"></div>
            <span class="px-4 text-gray-500 text-sm">Remember your password?</span>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <!-- Back to Login -->
        <a href="{{ route('login') }}" class="w-full block text-center bg-gray-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-gray-700 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Login
        </a>
    </div>
</div>

<script>
function forgotPasswordForm() {
    return {
        phone: '',
        submitting: false,
        phoneError: '',
        phoneSuccess: false,
        
        get isValid() {
            return this.phoneSuccess && !this.phoneError;
        },
        
        validatePhone() {
            this.phoneError = '';
            this.phoneSuccess = false;
            
            if (this.phone.length > 0) {
                const phonePattern = /^[6-9][0-9]{9}$/;
                if (!phonePattern.test(this.phone)) {
                    this.phoneError = 'Enter a valid 10-digit phone number starting with 6-9';
                } else {
                    this.phoneSuccess = true;
                }
            }
        }
    }
}
</script>
@endsection