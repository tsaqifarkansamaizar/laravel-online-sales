<label>Kategori
  <select name="category_id" required>
    <option value="">Pilih Kategori</option>
    @foreach($categories as $category)
      <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? null) == $category->id)>
        {{ $category->name }}
      </option>
    @endforeach
  </select>
</label>

<label>SKU (Kode Unik Produk)
  <input class="input" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required placeholder="Contoh: ELK-001">
</label>

<label>Nama Produk
  <input class="input" name="name" value="{{ old('name', $product->name ?? '') }}" required placeholder="Contoh: Headphone Bluetooth">
</label>

<label>Deskripsi
  <textarea class="input" rows="4" name="description">{{ old('description', $product->description ?? '') }}</textarea>
</label>

<label>Harga (Rp)
  <input class="input" type="number" min="0" step="0.01" name="price" value="{{ old('price', $product->price ?? 0) }}" required>
</label>

<label>Gambar Produk
  <input class="input" type="file" name="image" accept="image/*">
</label>

<label style="display:flex;align-items:center;gap:8px;margin-top:12px;">
  <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Status Aktif (Tampil di Katalog)
</label>

<button class="btn" style="margin-top:16px;">Simpan Produk</button>