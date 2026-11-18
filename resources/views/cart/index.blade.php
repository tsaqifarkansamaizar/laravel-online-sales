@extends('layouts.app')

@section('title','Keranjang')

@section('content')
<h1>Keranjang Belanja</h1>

@if($items->isEmpty())
  <div class="card">
    <p class="muted">Keranjang belanja Anda masih kosong.</p>
    <a class="btn" href="{{ route('shop.index') }}" style="margin-top:12px;">Mulai Belanja ↗</a>
  </div>
@else
  <div class="card table-scroll">
    <table>
      <thead>
        <tr>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
        <tr>
          <td><strong>{{ $item['product']->name }}</strong></td>
          <td>Rp{{ number_format($item['product']->price,2,',','.') }}</td>
          <td>
            <form class="row" method="POST" action="{{ route('cart.update',$item['product']) }}">
              @csrf
              @method('PATCH')
              <input class="input" style="width:70px" type="number" name="quantity" min="1" max="{{ $item['product']->stock }}" value="{{ $item['quantity'] }}">
              <button class="btn-light">Update</button>
            </form>
          </td>
          <td><strong>Rp{{ number_format($item['lineTotal'],2,',','.') }}</strong></td>
          <td>
            <form method="POST" action="{{ route('cart.destroy',$item['product']) }}">
              @csrf
              @method('DELETE')
              <button class="btn-danger" onclick="return confirm('Hapus produk dari keranjang?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="card" style="margin-top:18px;">
    <div class="row" style="justify-content:space-between;align-items:center;">
      <h3>Total Pembelian: <span style="color:#047857;">Rp{{ number_format($subtotal,2,',','.') }}</span></h3>
      @if(Route::has('checkout.index'))
        <a class="btn" href="{{ route('checkout.index') }}">Lanjut ke Checkout ↗</a>
      @endif
    </div>
  </div>
@endif
@endsection