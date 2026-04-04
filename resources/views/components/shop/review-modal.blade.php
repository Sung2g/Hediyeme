@props([
    'product',
    'userHasReviewed' => false,
    'openOnError' => false,
])

@if (! $userHasReviewed)
    <div
        x-data="{ open: @js($openOnError) }"
        x-on:open-shop-review.window="open = true"
        class="relative z-[200]"
    >
        <div
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"
            x-on:click="open = false"
            aria-hidden="true"
        ></div>

        <div
            x-show="open"
            x-cloak
            x-transition
            class="fixed inset-0 z-[201] flex items-center justify-center p-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="review-modal-title"
        >
            <div
                class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-gray-200"
                x-on:click.stop
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 id="review-modal-title" class="text-lg font-bold text-gray-900">Yorum yaz</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->name }}</p>
                    </div>
                    <button type="button" class="rounded-lg px-2 py-1 text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-700" x-on:click="open = false" aria-label="Kapat">&times;</button>
                </div>

                <form action="{{ route('shop.products.reviews.store', $product->slug) }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <input type="text" name="website" value="" class="absolute -left-[9999px] h-0 w-0" tabindex="-1" autocomplete="off" aria-hidden="true">

                    @guest('web')
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Ad Soyad</label>
                            <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="w-full rounded-xl border-gray-200 text-sm shadow-sm" required>
                            @error('guest_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">E-posta</label>
                            <input type="email" name="guest_email" value="{{ old('guest_email') }}" class="w-full rounded-xl border-gray-200 text-sm shadow-sm" required>
                            @error('guest_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endguest

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Puan</label>
                        <select name="rating" class="w-full rounded-xl border-gray-200 text-sm shadow-sm">
                            @for ($r = 5; $r >= 1; $r--)
                                <option value="{{ $r }}" {{ (int) old('rating', 5) === $r ? 'selected' : '' }}>{{ $r }} yildiz</option>
                            @endfor
                        </select>
                        @error('rating')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Yorumunuz</label>
                        <textarea name="body" rows="4" class="w-full rounded-xl border-gray-200 text-sm shadow-sm" placeholder="En az 10 karakter" required>{{ old('body') }}</textarea>
                        @error('body')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex flex-col-reverse gap-2 pt-2 sm:flex-row sm:justify-end">
                        <button type="button" class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50" x-on:click="open = false">
                            Vazgec
                        </button>
                        <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-700">
                            Gonder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
