<div class="offer-card">
    <div class="product-card h-100" data-url="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}">
        <div class="card">
            <div class="card__shine"></div>
            <div class="card__glow"></div>
            <div class="card__content">
                <div class="card__badge">{{ __('nav.product') }}</div>
                @php
                $price = $product->listPrices->first();
                $imagePath = 'products/' . $product->id . '.' . $product->extension;
                $storage = \Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath);
                @endphp
                @if($price && $price->shelf_price > 0 )
                <div style="--bg-color: #a78bfa" class="card__image">
                    @if($storage)
                    <img src="{{ asset('storage/' . $imagePath) }}"
                        alt="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}"
                        class="img-fluid w-100 h-100 dynamic-fit">
                    @endif
                </div>

                <div class="card__text">
                    <p class="card__title">
                        <a href="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}"
                            class="text-decoration-none text-dark">
                            {{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}
                        </a>
                    </p>
                    <p class="card__description">
                        {{ \Illuminate\Support\Str::limit($product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en, 80) }}
                    </p>
                </div>

                <div class="card__footer">
                    <div class="card__price">
                        @if($price->old_price > $price->shelf_price)
                        <small class="text-muted text-decoration-line-through me-1">
                            ${{ number_format($price->old_price, 2) }}
                        </small>
                        @endif
                        <span>${{ number_format($price->shelf_price, 2) }}</span>
                    </div>

                    <div class="card__button">
                        @php
                        $auth = auth('customer')->user();
                        $totalStock = $product->distributorStocks?->sum('stock') ?? 0;
                        @endphp
                        @if( !$auth)
                        <form action="{{ route('cart.store', ['locale' => app()->getLocale()]) }}"
                            method="POST" class="add-to-cart-form m-0">
                            @csrf
                            <input type="hidden" name="old_price" value="{{ $price->old_price }}">
                            <input type="hidden" name="type" value="{{ $price->type }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="{{ $totalStock }}">
                            <input type="hidden" name="unit_price" value="{{ $price->unit_price}}">
                            <input type="hidden" name="shelf_price" value="{{ $price->shelf_price }}">
                            <input type="hidden" name="description" value="{{ $product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en }}">
                            <input type="hidden" name="name" value="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}">
                            <input type="hidden" name="ea-ca" value="{{ $product->ea_ca ?? 12 }}">
                            <input type="hidden" name="ea-pl" value="{{ $product->ea_pl ?? 144 }}">
                            <input type="hidden" name="ea" value="{{ $price->EA }}">
                            <input type="hidden" name="ca" value="{{ $price->CA }}">
                            <input type="hidden" name="pl" value="{{ $price->PL }}">
                            <button type="submit" class="border-0 bg-transparent p-0">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                        @else
                        @if($totalStock > 0)
                        <form action="{{ route('cart.store', ['locale' => app()->getLocale()]) }}"
                            method="POST" class="add-to-cart-form m-0">
                            @csrf
                            <input type="hidden" name="old_price" value="{{ $price->old_price }}">
                            <input type="hidden" name="type" value="{{ $price->type }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="{{ $totalStock }}">
                            <input type="hidden" name="unit_price" value="{{ $price->unit_price}}">
                            <input type="hidden" name="shelf_price" value="{{ $price->shelf_price }}">
                            <input type="hidden" name="description" value="{{ $product->{'small_description_'.app()->getLocale()} ?? $product->small_description_en }}">
                            <input type="hidden" name="name" value="{{ $product->{'name_'.app()->getLocale()} ?? $product->name_en }}">
                            <input type="hidden" name="ea-ca" value="{{ $product->ea_ca ?? 12 }}">
                            <input type="hidden" name="ea-pl" value="{{ $product->ea_pl ?? 144 }}">
                            <input type="hidden" name="ea" value="{{ $price->EA }}">
                            <input type="hidden" name="ca" value="{{ $price->CA }}">
                            <input type="hidden" name="pl" value="{{ $price->PL }}">

                            <button type="submit" class="border-0 bg-transparent p-0">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                        @else
                        <button class="btn btn-sm btn-secondary" disabled>
                            {{ __('cart.out_of_stock') }}
                        </button>
                        @endif
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>