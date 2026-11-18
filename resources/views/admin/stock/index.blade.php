@extends('layouts.admin')

@section('title','Stok')

@section('content')
<div class="row" style="justify-content:space-between;margin-bottom:16px;">
  <h1>Histori Pergerakan Stok</h1>
  <a class="btn" href="{{ route('admin.stock.create') }}">+ Catat Barang Masuk</a>
</div>

<div class="card">
  <form class="row" method="GET">
    <label>Produk
      <select name="product_id">
        <option value="">Semua Produk</option>
        @foreach($products as $product)
          <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>
            {{ $product->name }}
          </option>
        @endforeach
      </select>
    </label>

    <label>Tipe
      <select name="type">
        <option value="">Semua Tipe</option>
        <option value="IN" @selected(request('type') == 'IN')>IN (Masuk)</option>
        <option value="OUT" @selected(request('type') == 'OUT')>OUT (Keluar)</option>
      </select>
    </label>

    <button class="btn" style="align-self:flex-end;margin-bottom:12px;">Filter</button>
  </form>
</div>

<div class="card">
  <div class="table-scroll">
    <table>
      <thead>
        <tr>
          <th>Waktu</th>
          <th>Produk</th>
          <th>Tipe</th>
          <th>Qty</th>
          <th>Referensi</th>
          <th>Admin / User</th>
        </tr>
      </thead>
      <tbody>
        @forelse($movements as $movement)
        <tr>
          <td>{{ $movement->movement_at->format('d-m-Y H:i') }}</td>
          <td><strong>{{ $movement->product->name }}</strong></td>
          <td>
            <span class="badge" style="background:{{ $movement->type === 'IN' ? '#dcfce7;color:#166534' : '#fee2e2;color:#991b1b' }}">
              {{ $movement->type }}
            </span>
          </td>
          <td><strong>{{ $movement->quantity }}</strong></td>
          <td>{{ $movement->reference ?? '-' }}</td>
          <td>{{ $movement->user?->name ?? 'Sistem' }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center;padding:24px;" class="muted">Belum ada riwayat pergerakan stok.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="margin-top:16px">{{ $movements->links() }}</div>
</div>
@endsection