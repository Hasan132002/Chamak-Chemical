<div class="relative" x-data x-on:cart-count-changed.window="$wire.updateCartCount()">
    <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-primary-500 to-blue-600 hover:from-primary-600 hover:to-blue-700 rounded-full transition-all shadow-lg hover:shadow-xl group">
        <i class="fas fa-shopping-cart text-base sm:text-xl text-white"></i>
        <span class="absolute -top-1.5 -right-1.5 sm:-top-2 sm:-right-2 bg-gradient-to-r from-secondary-500 to-orange-600 text-white text-[10px] sm:text-xs font-extrabold rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center shadow-xl border-2 border-white {{ $itemCount > 0 ? 'animate-bounce' : '' }}">
            {{ $itemCount }}
        </span>
    </a>
</div>
