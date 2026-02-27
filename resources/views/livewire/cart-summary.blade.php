<div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
    <h3 class="font-bold text-xl mb-6 flex items-center">
        <i class="fas fa-calculator mr-2 text-primary-500"></i>{{ __('Order Summary') }}
    </h3>

    <div class="space-y-4 mb-6">
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">{{ __('Subtotal') }}</span>
            <span class="font-bold text-lg">PKR {{ number_format($subtotal, 0) }}</span>
        </div>

        @if($discount > 0)
        <div class="flex justify-between items-center pb-3 border-b text-green-600">
            <span class="flex items-center gap-1">
                <i class="fas fa-tag"></i>{{ __('Discount') }}
            </span>
            <span class="font-bold text-lg">- PKR {{ number_format($discount, 0) }}</span>
        </div>
        @endif

        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">{{ __('Shipping') }}</span>
            <span class="font-bold text-lg">PKR {{ number_format($shipping, 0) }}</span>
        </div>
        <div class="flex justify-between items-center pt-2">
            <span class="text-lg font-bold">{{ __('Total') }}</span>
            <span class="text-2xl font-extrabold text-primary-600">PKR {{ number_format($total, 0) }}</span>
        </div>
    </div>

    <!-- Coupon -->
    <div class="mb-6">
        @if($appliedCoupon)
            <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-xl px-4 py-3 mb-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="font-semibold text-green-700 text-sm">{{ $appliedCoupon['code'] }}</span>
                </div>
                <button wire:click="removeCoupon" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                    <i class="fas fa-times mr-1"></i>{{ __('Remove') }}
                </button>
            </div>
        @else
            <div class="flex gap-2">
                <input type="text" wire:model="couponCode" wire:keydown.enter="applyCoupon"
                       placeholder="{{ __('Coupon Code') }}"
                       class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 uppercase">
                <button wire:click="applyCoupon" wire:loading.attr="disabled"
                        class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition">
                    <span wire:loading.remove wire:target="applyCoupon"><i class="fas fa-tag mr-1"></i>{{ __('Apply') }}</span>
                    <span wire:loading wire:target="applyCoupon"><i class="fas fa-spinner fa-spin"></i></span>
                </button>
            </div>
        @endif

        @if($couponMessage)
            <p class="text-sm mt-2 {{ $couponError ? 'text-red-500' : 'text-green-600' }}">
                <i class="fas {{ $couponError ? 'fa-exclamation-circle' : 'fa-check-circle' }} mr-1"></i>
                {{ $couponMessage }}
            </p>
        @endif
    </div>

    <a href="{{ route('checkout.index') }}"
       class="block w-full bg-gradient-to-r from-secondary-500 to-orange-600 hover:from-secondary-600 hover:to-orange-700 text-white text-center font-bold py-4 rounded-xl transition shadow-lg hover:shadow-xl mb-4">
        <i class="fas fa-credit-card mr-2"></i>{{ __('Proceed to Checkout') }}
    </a>

    <a href="{{ route('products.index') }}"
       class="block w-full text-center text-primary-500 hover:text-primary-600 font-semibold mt-4">
        <i class="fas fa-arrow-left mr-2"></i>{{ __('Continue Shopping') }}
    </a>
</div>
