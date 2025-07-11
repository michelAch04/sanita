@php
$cardType = $type == 'categories' ? 'category' : 'category';
@endphp
<div class="category-card mb-4" data-url="{{ route('website.' . $cardType . '.index', ['locale' => app()->getLocale(), $cardType => $category->id]) }}">
    <div class="category-card-body">
        @if($category->extension)
        <img src="
        {{ asset('storage/' . $type . '/' . $category->id . '.' . $category->extension) }}"
            alt="{{ $category->{'name_'.app()->getLocale()} ?? $category->name_en }}"
            class="img-fluid">
        @endif
        <h5 class="card-title">
            <a href="{{ route('website.' . $cardType . '.index', ['locale' => app()->getLocale(), $cardType => $category->id]) }}"
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