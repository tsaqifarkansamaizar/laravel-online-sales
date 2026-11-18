@extends('layouts.admin')

@section('title','Barang Masuk')

@section('content')
<h1>Barang Masuk / Penyetokan</h1>

<div class="card">
  <form method="POST" action="{{ route('admin.stock.store') }}">
    @csrf
    <label>Produk
      <select name="product_id" required>
        <option value="">Pilih Produk</option>
        @foreach($products as $product)
          <option value="{{ $product->id }}">
            {{ $product->sku }} - {{ $product->name }} (Stok saat ini: {{ $product->stock }})
          </option>
        @endforeach
      </select>
    </label>

    <label>Jumlah Masuk
      <input class="input" type="number" min="1" name="quantity" required placeholder="Contoh: 10">
    </label>

    <label>Harga Beli per Unit (Opsional)
      <input class="input" type="number" min="0" step="0.01" name="unit_cost" placeholder="Rp">
    </label>

    <label>Referensi / No. Faktur (Opsional)
      <input class="input" name="reference" placeholder="Contoh: INV-IN-001">
    </label>

    <label>Tanggal Masuk
      <input class="input" type="datetime-local" name="movement_at" value="{{ now()->format('Y-m-d\TH:i') }}" required>
    </label>

    <label>Catatan
      <textarea class="input" rows="3" name="note" placeholder="Catatan supplier, kondisi barang, dll."></textarea>
    </label>

    <button class="btn" style="margin-top:12px;">Simpan Barang Masuk</button>
  </form>
</div>
@endsection