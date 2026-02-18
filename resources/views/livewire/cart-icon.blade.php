<div class="relative">
    <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center w-14 h-14 bg-gradient-to-br from-primary-500 to-blue-600 hover:from-primary-600 hover:to-blue-700 rounded-full transition-all shadow-lg hover:shadow-xl group">
        <i class="fas fa-shopping-cart text-2xl text-white"></i>
        <span class="absolute -top-2 -right-2 bg-gradient-to-r from-secondary-500 to-orange-600 text-white text-sm font-extrabold rounded-full w-7 h-7 flex items-center justify-center shadow-xl border-2 border-white {{ $itemCount > 0 ? 'animate-bounce' : '' }}">
            {{ $itemCount }}
        </span>
    </a>
</div>
