<div class="flex items-center gap-4">
    <div class="flex items-center border-2 border-gray-300 rounded-xl overflow-hidden bg-white shadow-sm">
        <button wire:click="decrement" type="button" class="px-4 py-2 hover:bg-primary-500 hover:text-white transition font-bold text-lg">
            <i class="fas fa-minus"></i>
        </button>
        <div class="px-6 py-2 border-x-2 border-gray-300 min-w-20 text-center">
            <span class="text-2xl font-extrabold text-gray-900">{{ $quantity }}</span>
        </div>
        <button wire:click="increment" type="button" class="px-4 py-2 hover:bg-primary-500 hover:text-white transition font-bold text-lg">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <button wire:click="remove" wire:confirm="Are you sure you want to remove this item?" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition shadow-sm hover:shadow-md">
        <i class="fas fa-trash-alt"></i>
    </button>
</div>
