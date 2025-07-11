<div class="category-card mb-4" data-url="{{ route('website.category.index', ['locale' => app()->getLocale(), 'category' => $category->id]) }}">
    <div class="category-card-body p-2">
        @if($category->extension)
        <img src="{{ asset('storage/categories/' . $category->id . '.' . $category->extension) }}"
            alt="{{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}"
            class="img-fluid mb-5">
        @endif
        <h5 class="card-title">
            <a href="{{ route('website.category.index', ['locale' => app()->getLocale(), 'category' => $category->id]) }}"
                class="text-decoration-none text-primary">
                {{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}
            </a>
        </h5>
        @if(!empty($category->description))
        <p class="card-text text-muted text-center small">
            {{ $category->{'description_'.app()->getLocale()} ?? $category->description }}
        </p>
        @endif
    </div>
</div>