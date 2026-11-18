@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="card">
  <div class="checkout-layout">
    @if($product->image)
      <img class="thumb" style="height:340px;object-fit:cover;" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
    @else
      <div class="thumb" style="height:340px;">□</div>
    @endif
    <div>
      <div class="muted">{{ $product->category->name }} | {{ $product->sku }}</div>
      <h1>{{ $product->name }}</h1>
      <p style="margin:12px 0;">{{ $product->description }}</p>
      <p class="price" style="font-size:1.5rem;margin-bottom:8px;">Rp{{ number_format($product->price,2,',','.') }}</p>
      <p style="margin-bottom:16px;">Stok tersedia: <strong>{{ $product->stock }}</strong></p>

      @auth
        @if(auth()->user()->role==='customer' && $product->stock>0 && Route::has('cart.store'))
          <form method="POST" action="{{ route('cart.store',$product) }}">
            @csrf
            <label>Jumlah
              <input class="input" style="max-width:120px" type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1">
            </label>
            <button class="btn" style="margin-top:8px;">Tambah ke Keranjang</button>
          </form>
        @elseif($product->stock===0)
          <p class="badge cancelled" style="padding:8px 12px;font-size:0.9rem;">Stok habis. Cek kembali nanti.</p>
        @endif
      @else
        <p><a href="{{ route('login') }}">Login</a> untuk berbelanja.</p>
      @endauth
    </div>
  </div>
</div>
@endsection