<div>
    @if(session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg mb-4 animate__animated animate__fadeIn">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-4 animate__animated animate__fadeIn">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Size/Weight Selector -->
    @if(!empty($variants))
        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-3">
                <i class="fas fa-weight-hanging mr-2 text-primary-500"></i>{{ __('Select Size/Weight') }}
            </label>
            <div class="grid grid-cols-2 gap-3">
                <!-- Base Product Option -->
                <button wire:click="$set('selectedVariant', null)"
                        type="button"
                        class="px-4 py-3 rounded-xl border-2 transition font-semibold {{ $selectedVariant === null ? 'border-primary-500 bg-primary-50 text-primary-700' : 'border-gray-300 hover:border-primary-300' }}">
                    <i class="fas fa-box mr-2"></i>Standard
                </button>

                <!-- Variations -->
                @foreach($variants as $key => $variant)
                    <button wire:click="$set('selectedVariant', '{{ $key }}')"
                            type="button"
                            class="px-4 py-3 rounded-xl border-2 transition font-semibold {{ $selectedVariant === $key ? 'border-primary-500 bg-primary-50 text-primary-700' : 'border-gray-300 hover:border-primary-300' }}">
                        {{ $variant['label'] }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Dynamic Price Display -->
    <div class="mb-6 bg-gradient-to-r from-primary-50 to-blue-50 rounded-xl p-6 border-2 border-primary-200">
        <div class="text-sm text-gray-600 mb-1">{{ __('Price') }}:</div>
        <div class="text-4xl font-extrabold text-primary-600">
            PKR {{ number_format($currentPrice, 0) }}
        </div>
        @if($selectedVariant)
            <div class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle mr-1"></i>{{ __('For') }} {{ $variants[$selectedVariant]['label'] ?? '' }}
            </div>
        @endif
    </div>

    <div class="bg-gray-50 rounded-xl p-6 mb-6">
        <div class="flex items-center gap-4">
            <!-- Quantity Selector with Icons -->
            <div class="flex items-center border-2 border-gray-300 rounded-xl overflow-hidden bg-white shadow-sm">
                <button wire:click="decrement"
                        type="button"
                        class="px-5 py-3 hover:bg-primary-500 hover:text-white transition font-bold text-xl">
                    <i class="fas fa-minus"></i>
                </button>
                <div class="px-6 py-3 border-x-2 border-gray-300 min-w-20 text-center">
                    <span class="text-2xl font-bold text-gray-900">{{ $quantity }}</span>
                </div>
                <button wire:click="increment"
                        type="button"
                        class="px-5 py-3 hover:bg-primary-500 hover:text-white transition font-bold text-xl">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <!-- Add to Cart Button -->
            <button wire:click="addToCart"
                    @if($product->isOutOfStock()) disabled @endif
                    class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 disabled:from-gray-400 disabled:to-gray-400 text-white font-bold py-4 px-8 rounded-xl transition shadow-lg hover:shadow-xl">
                @if($product->isOutOfStock())
                    <i class="fas fa-ban mr-2"></i>{{ __('Out of Stock') }}
                @else
                    <i class="fas fa-shopping-cart mr-2"></i>{{ __('Add to Cart') }}
                @endif
            </button>
        </div>
    </div>

    <!-- Buy Now -->
    @if(!$product->isOutOfStock())
        <button wire:click="addToCart"
                class="w-full bg-gradient-to-r from-secondary-500 to-orange-600 hover:from-secondary-600 hover:to-orange-700 text-white font-bold py-4 px-8 rounded-xl transition shadow-lg hover:shadow-xl">
            <i class="fas fa-bolt mr-2"></i>{{ __('Buy Now') }}
        </button>
    @endif

    <div class="mt-6 text-sm text-gray-600 flex items-center justify-center gap-4">
        <span class="flex items-center"><i class="fas fa-shield-alt text-green-500 mr-2"></i>{{ __('Secure Payment') }}</span>
        <span class="flex items-center"><i class="fas fa-undo text-blue-500 mr-2"></i>{{ __('Easy Returns') }}</span>
    </div>
</div>
