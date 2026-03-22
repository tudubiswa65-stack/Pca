@extends('layouts.public')

@section('title', 'Verify OTP - Padmabati Computer Academy')

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-mobile-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-navy-900 mb-2">Verify Your Phone</h1>
            <p class="text-gray-600">Enter the 6-digit OTP sent to</p>
            <p class="text-navy-900 font-semibold">{{ $phone ?? 'your phone' }}</p>
        </div>

        <!-- OTP Form -->
        <form method="POST" action="{{ route('otp.verify') }}" x-data="otpForm()">
            @csrf
            
            <!-- OTP Input -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-4 text-center">
                    <i class="fas fa-key mr-1"></i>
                    Enter 6-Digit OTP
                </label>
                
                <div class="flex justify-center space-x-2 mb-4">
                    <template x-for="(digit, index) in otpDigits" :key="index">
                        <input 
                            type="text" 
                            maxlength="1"
                            x-model="otpDigits[index]"
                            @input="handleInput(index, $event)"
                            @keydown="handleKeyDown(index, $event)"
                            @paste="handlePaste($event)"
                            class="w-12 h-12 text-center text-lg font-bold border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200"
                            :ref="'otp_' + index"
                        >
                    </template>
                </div>
                
                <input type="hidden" name="otp" :value="otpValue">
                
                @error('otp')
                    <p class="text-red-500 text-sm text-center mt-2">{{ $message }}</p>
                @enderror
                <p x-show="otpError" x-text="otpError" class="text-red-500 text-sm text-center mt-2"></p>
            </div>

            <!-- Timer and Resend -->
            <div class="text-center mb-6">
                <div x-show="timeLeft > 0" class="text-gray-600 mb-4">
                    <i class="fas fa-clock mr-1"></i>
                    Resend OTP in <span class="font-bold text-blue-600" x-text="Math.floor(timeLeft / 60) + ':' + (timeLeft % 60).toString().padStart(2, '0')"></span>
                </div>
                
                <button 
                    type="button" 
                    x-show="timeLeft <= 0" 
                    @click="resendOtp()"
                    :disabled="resending"
                    class="text-blue-600 hover:text-blue-700 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span x-show="!resending">
                        <i class="fas fa-redo mr-1"></i>
                        Resend OTP
                    </span>
                    <span x-show="resending">
                        <i class="fas fa-spinner fa-spin mr-1"></i>
                        Sending...
                    </span>
                </button>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                :disabled="otpValue.length !== 6 || submitting"
                class="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold py-3 px-4 rounded-xl hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span x-show="!submitting">
                    <i class="fas fa-check mr-2"></i>
                    Verify OTP
                </span>
                <span x-show="submitting" class="flex items-center justify-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Verifying...
                </span>
            </button>
        </form>

        <!-- Help Text -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Didn't receive the OTP?</p>
            <p>Check your phone messages or wait for the timer to resend.</p>
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
function otpForm() {
    return {
        otpDigits: ['', '', '', '', '', ''],
        timeLeft: 120, // 2 minutes
        resending: false,
        submitting: false,
        otpError: '',
        
        get otpValue() {
            return this.otpDigits.join('');
        },
        
        init() {
            this.startTimer();
            this.$nextTick(() => {
                this.$refs.otp_0.focus();
            });
        },
        
        startTimer() {
            const timer = setInterval(() => {
                this.timeLeft--;
                if (this.timeLeft <= 0) {
                    clearInterval(timer);
                }
            }, 1000);
        },
        
        handleInput(index, event) {
            const value = event.target.value.replace(/[^0-9]/g, '');
            this.otpDigits[index] = value;
            this.otpError = '';
            
            if (value && index < 5) {
                this.$refs['otp_' + (index + 1)].focus();
            }
            
            // Auto submit if all digits are filled
            if (this.otpValue.length === 6) {
                this.$nextTick(() => {
                    this.$el.closest('form').submit();
                });
            }
        },
        
        handleKeyDown(index, event) {
            if (event.key === 'Backspace') {
                if (!this.otpDigits[index] && index > 0) {
                    this.$refs['otp_' + (index - 1)].focus();
                }
                this.otpDigits[index] = '';
            } else if (event.key === 'ArrowLeft' && index > 0) {
                this.$refs['otp_' + (index - 1)].focus();
            } else if (event.key === 'ArrowRight' && index < 5) {
                this.$refs['otp_' + (index + 1)].focus();
            }
        },
        
        handlePaste(event) {
            event.preventDefault();
            const paste = event.clipboardData.getData('text').replace(/[^0-9]/g, '');
            const digits = paste.slice(0, 6).split('');
            
            digits.forEach((digit, index) => {
                if (index < 6) {
                    this.otpDigits[index] = digit;
                }
            });
            
            if (digits.length > 0) {
                const lastIndex = Math.min(digits.length - 1, 5);
                this.$refs['otp_' + lastIndex].focus();
            }
        },
        
        async resendOtp() {
            this.resending = true;
            
            try {
                const response = await fetch('{{ route("otp.resend") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    this.timeLeft = 120;
                    this.startTimer();
                    // Show success message
                    this.showMessage('OTP resent successfully!', 'success');
                } else {
                    this.otpError = data.error || 'Failed to resend OTP. Please try again.';
                }
            } catch (error) {
                this.otpError = 'Network error. Please try again.';
            } finally {
                this.resending = false;
            }
        },
        
        showMessage(message, type) {
            // Create temporary flash message
            const messageDiv = document.createElement('div');
            messageDiv.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-teal-600' : 'bg-red-600'} text-white`;
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                    ${message}
                </div>
            `;
            document.body.appendChild(messageDiv);
            
            setTimeout(() => {
                messageDiv.remove();
            }, 5000);
        }
    }
}
</script>
@endsection