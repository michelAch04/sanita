<div class="category-card mb-4" data-url="{{ route('website.brand.index', ['locale' => app()->getLocale(), 'brand' => $brand->id]) }}">
    <div class="category-card-body">
        @if($category->extension)
        <img src="
        {{ asset('storage/brands/' . $brand->id . '.' . $brand->extension) }}"
            alt="{{ $brand->{'name_'.app()->getLocale()} ?? $brand->name_en }}"
            class="img-fluid">
        @endif
        <h5 class="card-title">
            <a href="{{ route('website.brand.index', ['locale' => app()->getLocale(), 'brand' => $brand->id]) }}"
                class="text-decoration-none text-primary">
                {{ $brand->{'name_'.app()->getLocale()} ?? $brand->name_en }}
            </a>
        </h5>
    </div>
</div>