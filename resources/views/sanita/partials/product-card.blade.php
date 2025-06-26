<div class="offer-card">
    <div class="product-card h-100" data-url="{{ route('website.product.index', ['locale' => app()->getLocale(), 'product' => $product->id]) }}">
        <div class="card">
            <div class="card__shine"></div>
            <div class="card__glow"></div>
            <div class="card__content">
                <div class="card__badge">{{ __('nav.product') }}</div>

                <div style="--bg-color: #a78bfa" class="card__image">
                    @if($product->extension)
                        <img src="{{ asset('storage/products/' . $product->id . '.' . $product->extension) }}"
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
                        @if($product->old_price > $product->shelf_price)
                            <small class="text-muted text-decoration-line-through me-1">
                                ${{ number_format($product->old_price, 2) }}
                            </small>
                        @endif
                        <span>${{ number_format($product->shelf_price, 2) }}</span>
                    </div>

                    <div class="card__button">
                        @if($product->available_quantity > 0)
                            <form action="{{ route('cart.store', ['locale' => app()->getLocale()]) }}"
                                  method="POST" class="add-to-cart-form m-0">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="price" value="{{ $product->shelf_price }}">
                                <input type="hidden" name="description" value="{{ $product->{'description_'.app()->getLocale()} ?? $product->description }}">
                                <button type="submit" class="border-0 bg-transparent p-0">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-secondary" disabled>
                                {{ __('cart.out_of_stock') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
