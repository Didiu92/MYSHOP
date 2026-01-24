<div class="card p-6 product-card cursor-pointer {{ $class }}">
    @if($category->image)
        <div class="w-full h-32 mb-4 overflow-hidden rounded-lg bg-ebony">
            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
        </div>
    @else
        <div class="text-4xl text-gold mb-4">📦</div>
    @endif
    <h4 class="text-xl font-bold mb-2 text-gold">{{ $category->name }}</h4>
    <p class="text-silver mb-4">{{ $category->description }}</p>
    <a href="{{ route('categories.show', $category->id) }}" 
       class="text-gold font-semibold hover:text-copper transition">
        Ver Productos →
    </a>
</div>