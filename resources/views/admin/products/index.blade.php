@extends('admin.layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<section class="catalog-section">
  <div class="section-top">
    <div>
      <span class="section-label">MANAJEMEN PRODUK</span>
      <h2>Kelola Produk</h2>
    </div>
    <p>
      Kelola katalog produk Anda dengan mudah. Tambah produk baru, edit informasi,
      atau hapus produk yang tidak diperlukan.
    </p>
  </div>

  <div class="toolbar">
    <div class="search-area">
      <form method="GET" action="{{ route('admin.products.index') }}" style="display: flex;">
        <input type="text" name="search" placeholder="Cari produk, kategori, atau lokasi..." value="{{ request('search') }}" />
      </form>
    </div>

    <div class="toolbar-controls">
      <select onchange="filterByCategory(this.value)">
        <option value="">Semua Kategori</option>
        <option value="Elektronik" @if(request('category') == 'Elektronik') selected @endif>Elektronik</option>
        <option value="Fashion" @if(request('category') == 'Fashion') selected @endif>Fashion</option>
        <option value="Rumah Tangga" @if(request('category') == 'Rumah Tangga') selected @endif>Rumah Tangga</option>
        <option value="Kecantikan" @if(request('category') == 'Kecantikan') selected @endif>Kecantikan</option>
        <option value="Makanan" @if(request('category') == 'Makanan') selected @endif>Makanan</option>
        <option value="Aksesoris" @if(request('category') == 'Aksesoris') selected @endif>Aksesoris</option>
      </select>

      <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-small">+ Tambah Produk</a>
    </div>
  </div>

  <div class="catalog-layout">
    <aside class="sidebar">
      <div class="side-card">
        <h3>Filter Cepat</h3>
        <label><input type="checkbox" checked /> Semua produk</label>
        <label><input type="checkbox" /> Ready stock</label>
        <label><input type="checkbox" /> Rating 4 ke atas</label>
      </div>

      <div class="side-card">
        <h3>Statistik</h3>
        <p style="font-size: 14px; color: var(--c6); line-height: 1.8;">
          <strong style="color: var(--c1);">Total Produk:</strong> {{ $products->count() }}<br>
          <strong style="color: var(--c1);">Kategori:</strong> 6<br>
          <strong style="color: var(--c1);">Stok Tersedia:</strong> {{ $products->where('stock', '>', 0)->count() }}
        </p>
      </div>
    </aside>

    <div class="product-grid">
      @forelse($products as $product)
        <article class="product-card">
          <div class="product-thumb">
            @if($product->image)
              @if(str_starts_with($product->image, 'http'))
                <img src="{{ $product->image }}" alt="{{ $product->productName }}" />
              @else
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->productName }}" />
              @endif
            @else
              <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=80" alt="{{ $product->productName }}" />
            @endif
            @if($product->stock == 0)
              <span class="label-chip">Habis</span>
            @elseif($product->stock < 10)
              <span class="label-chip">Terbatas</span>
            @endif
          </div>
          <div class="product-body">
            <span class="category">{{ $product->category }}</span>
            <h3>{{ $product->productName }}</h3>
            <p class="meta">⭐ {{ $product->rating ?? 0 }} · Stok: {{ $product->stock }}</p>
            <div class="price-row">
              <h4>Rp{{ number_format($product->price, 0, ',', '.') }}</h4>
              <span>{{ $product->location }}</span>
            </div>
            <div class="product-buttons">
              <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline">Edit</a>
              <button type="button" class="btn btn-danger" onclick="openDeleteModal({{ $product->id }})">Hapus</button>
            </div>
          </div>
        </article>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
          <p style="font-size: 16px; color: var(--c6);">Tidak ada produk ditemukan</p>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  function filterByCategory(category) {
    const url = new URL(window.location);
    if (category) {
      url.searchParams.set('category', category);
    } else {
      url.searchParams.delete('category');
    }
    window.location = url.toString();
  }
</script>
@endsection
