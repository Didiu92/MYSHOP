<div class="card p-6 product-card cursor-pointer {{ $class }}">
    <div class="text-4xl text-gold mb-4">📦</div>
    <h4 class="text-xl font-bold mb-2 text-gold">{{ $category->name }}</h4>
    <p class="text-silver mb-4">{{ $category->description }}</p>
    <a href="{{ route('categories.show', $category->id) }}" 
       class="text-gold font-semibold hover:text-copper transition">
        Ver Productos →
    </a>
</div>