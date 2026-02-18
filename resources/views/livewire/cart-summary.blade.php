<div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
    <h3 class="font-bold text-xl mb-6 flex items-center">
        <i class="fas fa-calculator mr-2 text-primary-500"></i>{{ __('Order Summary') }}
    </h3>

    <div class="space-y-4 mb-6">
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">{{ __('Subtotal') }}</span>
            <span class="font-bold text-lg">PKR {{ number_format($subtotal, 0) }}</span>
        </div>
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
        <input type="text" placeholder="{{ __('Coupon Code') }}"
               class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl mb-2 focus:outline-none focus:border-primary-500">
        <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 rounded-xl transition">
            <i class="fas fa-tag mr-2"></i>{{ __('Apply Coupon') }}
        </button>
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
