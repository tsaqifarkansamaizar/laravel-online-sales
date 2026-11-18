@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1>Checkout Pesanan</h1>

<form action="{{ route('checkout.store') }}" method="POST">
  @csrf
  <input type="hidden" name="token" value="{{ $checkoutToken }}">

  <div class="checkout-layout">
    <div>
      <div class="card">
        <h3>Informasi Pengiriman</h3>

        <label>Nama Penerima
          <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->name) }}" required>
          @error('recipient_name') <span class="validation-error">{{ $message }}</span> @enderror
        </label>

        <label>Nomor Telepon / WhatsApp
          <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
          @error('phone') <span class="validation-error">{{ $message }}</span> @enderror
        </label>

        <label>Alamat Lengkap Pengiriman
          <textarea name="address" rows="3" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos" required>{{ old('address') }}</textarea>
          @error('address') <span class="validation-error">{{ $message }}</span> @enderror
        </label>

        <label>Pilih Layanan Pengiriman
          <select name="shipping_service_id" required>
            <option value="">-- Pilih Ekspedisi Pengiriman --</option>
            @foreach($shippingServices as $service)
              <option value="{{ $service->id }}" data-cost="{{ $service->cost }}" {{ old('shipping_service_id') == $service->id ? 'selected' : '' }}>
                {{ $service->courier }} - {{ $service->service }} (Rp{{ number_format($service->cost, 2, ',', '.') }} · ETA: {{ $service->eta }})
              </option>
            @endforeach
          </select>
          @error('shipping_service_id') <span class="validation-error">{{ $message }}</span> @enderror
        </label>
      </div>

      <div class="card table-scroll">
        <h3>Daftar Barang</h3>
        <table>
          <thead>
            <tr>
              <th>Produk</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td><strong>{{ $item['product']->name }}</strong></td>
              <td>Rp{{ number_format($item['product']->price, 2, ',', '.') }}</td>
              <td>{{ $item['quantity'] }}</td>
              <td>Rp{{ number_format($item['lineTotal'], 2, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div>
      <div class="card">
        <h3>Ringkasan Pembayaran</h3>

        <div class="summary-line">
          <span>Subtotal Produk</span>
          <span data-subtotal="{{ $subtotal }}">Rp{{ number_format($subtotal, 2, ',', '.') }}</span>
        </div>

        <div class="summary-line">
          <span>Ongkos Kirim</span>
          <span data-shipping-total>Pilih ekspedisi</span>
        </div>

        <hr style="margin: 12px 0; border: none; border-top: 1px solid var(--border);">

        <div class="summary-line summary-total">
          <span>Total Tagihan</span>
          <span data-order-total>Rp{{ number_format($subtotal, 2, ',', '.') }}</span>
        </div>

        <button type="submit" class="btn" style="width: 100%; margin-top: 16px; padding: 12px; font-size: 1rem;">
          Buat Pesanan Sekarang ↗
        </button>

        <a href="{{ route('cart.index') }}" class="btn-light" style="width: 100%; text-align: center; margin-top: 8px;">
          ← Kembali ke Keranjang
        </a>
      </div>
    </div>
  </div>
</form>
@endsection