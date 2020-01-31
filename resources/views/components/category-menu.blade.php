<section class="desktop-content">
    @forelse ($categories as $category)
    <div class="item">
        <span class="item__square">
            <a href="{{ route('products', ['category' => $category]) }}">
                <h2 class="item__title">{{ $category->name }}</h2>
                <p class="item__number">{{ $category->products_count }}
                    @if ($category->products_count == 1)
                    item
                    @else
                    items
                    @endif
                </p>
            </a>
        </span>
        <a title="{{ $category->name }}" href="{{ route('products', ['category' => $category]) }}"
            style="background: url({{ asset($category->photo_path) }}) no-repeat center/contain">
        </a>
    </div>
    @empty
    No categories were found.
    @endforelse
</section>