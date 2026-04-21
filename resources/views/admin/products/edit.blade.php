@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<section class="catalog-section">
  <div class="section-top">
    <div>
      <span class="section-label">EDIT PRODUK</span>
      <h2>{{ $product->productName }}</h2>
    </div>
    <p>
      Perbarui informasi produk sesuai kebutuhan Anda.
    </p>
  </div>

  <div style="max-width: 800px; margin: 0 auto;">
    <div style="background: rgba(255, 255, 255, 0.88); border: 1px solid rgba(57, 69, 8, 0.08); border-radius: 24px; padding: 32px; box-shadow: var(--shadow-md);">
      <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="productName">Nama Produk *</label>
          <input type="text" id="productName" name="productName" value="{{ old('productName', $product->productName) }}" required />
          @error('productName')
            <div class="error-text">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="description">Deskripsi *</label>
          <textarea id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
          @error('description')
            <div class="error-text">{{ $message }}</div>
          @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          <div class="form-group">
            <label for="price">Harga (Rp) *</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required />
            @error('price')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="stock">Stok *</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required />
            @error('stock')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          <div class="form-group">
            <label for="category">Kategori *</label>
            <select id="category" name="category" required>
              <option value="">Pilih Kategori</option>
              <option value="Elektronik" @if(old('category', $product->category) == 'Elektronik') selected @endif>Elektronik</option>
              <option value="Fashion" @if(old('category', $product->category) == 'Fashion') selected @endif>Fashion</option>
              <option value="Rumah Tangga" @if(old('category', $product->category) == 'Rumah Tangga') selected @endif>Rumah Tangga</option>
              <option value="Kecantikan" @if(old('category', $product->category) == 'Kecantikan') selected @endif>Kecantikan</option>
              <option value="Makanan" @if(old('category', $product->category) == 'Makanan') selected @endif>Makanan</option>
              <option value="Aksesoris" @if(old('category', $product->category) == 'Aksesoris') selected @endif>Aksesoris</option>
            </select>
            @error('category')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="location">Lokasi *</label>
            <input type="text" id="location" name="location" value="{{ old('location', $product->location) }}" required />
            @error('location')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          <div class="form-group">
            <label for="rating">Rating (0-5)</label>
            <input type="number" id="rating" name="rating" value="{{ old('rating', $product->rating) }}" step="0.1" min="0" max="5" />
            @error('rating')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="label">Label (Terlaris, Diskon, Baru, dll)</label>
            <input type="text" id="label" name="label" value="{{ old('label', $product->label) }}" placeholder="Contoh: Terlaris" />
            @error('label')
              <div class="error-text">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="image">Gambar Produk</label>
          @if($product->image)
            <div style="margin-bottom: 12px;">
              @if(str_starts_with($product->image, 'http'))
                <img src="{{ $product->image }}" alt="{{ $product->productName }}" style="max-width: 200px; border-radius: 12px;" />
              @else
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->productName }}" style="max-width: 200px; border-radius: 12px;" />
              @endif
            </div>
          @endif
          <input type="file" id="image" name="image" accept="image/*" />
          @error('image')
            <div class="error-text">{{ $message }}</div>
          @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 32px;">
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="flex: 1; justify-content: center;">Batal</a>
          <button type="submit" class="btn btn-primary" style="flex: 1;">Perbarui Produk</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
