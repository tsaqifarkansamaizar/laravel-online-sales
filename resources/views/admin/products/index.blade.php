@extends('layouts.admin')

@section('title','Produk')

@section('content')
<div class="row" style="justify-content:space-between;margin-bottom:16px;">
  <h1>Produk</h1>
  <a class="btn" href="{{ route('admin.products.create') }}">+ Tambah Produk</a>
</div>

<div class="card">
  <form method="GET" class="row">
    <input class="input" style="max-width:320px" name="q" value="{{ request('q') }}" placeholder="Cari nama atau SKU...">
    <button class="btn">Cari</button>
  </form>
</div>

<div class="card">
  <div class="table-scroll">
    <table>
      <thead>
        <tr>
          <th>SKU</th>
          <th>Gambar</th>
          <th>Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
        <tr>
          <td><strong>{{ $product->sku }}</strong></td>
          <td>
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:48px;height:48px;object-fit:cover;border-radius:4px;">
            @else
              <span class="muted">Tanpa foto</span>
            @endif
          </td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->category->name }}</td>
          <td>Rp{{ number_format($product->price, 2, ',', '.') }}</td>
          <td>{{ $product->stock }}</td>
          <td>
            <span class="badge" style="background:{{ $product->is_active ? '#dcfce7;color:#166534' : '#fee2e2;color:#991b1b' }}">
              {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
          </td>
          <td class="row">
            <a class="btn-light" href="{{ route('admin.products.edit', $product) }}">Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
              @csrf
              @method('DELETE')
              <button class="btn-danger" onclick="return confirm('Hapus/Nonaktifkan produk ini?')">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" style="text-align:center;padding:24px;" class="muted">Belum ada data produk. Klik "+ Tambah Produk" di atas.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="margin-top:16px">{{ $products->links() }}</div>
</div>
@endsection