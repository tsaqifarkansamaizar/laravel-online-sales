@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->code)

@section('content')
<div class="section-heading">
  <div>
    <span class="eyebrow">PESANAN PELANGGAN</span>
    <h1>Detail Pesanan #{{ $order->code }}</h1>
  </div>
  <a class="btn-light" href="{{ route('orders.index') }}">← Riwayat Pesanan</a>
</div>

<div class="card" style="margin-bottom: 20px;">
  <div class="row" style="justify-content: space-between; align-items: center;">
    <div>
      <span class="muted" style="font-size: 0.85rem;">Tanggal Pemesanan:</span>
      <p style="font-weight: 600;">{{ $order->ordered_at ? $order->ordered_at->format('d F Y, H:i') : $order->created_at->format('d F Y, H:i') }} WIB</p>
    </div>
    <div>
      <span class="muted" style="font-size: 0.85rem;">Status Pesanan:</span>
      <div>
        @if($order->status === 'pending')
          <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 0.95rem; padding: 6px 12px;">Menunggu Validasi Admin (Pending)</span>
        @elseif($order->status === 'confirmed')
          <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 0.95rem; padding: 6px 12px;">Tervalidasi (Confirmed)</span>
        @elseif($order->status === 'processed')
          <span class="badge" style="background: #ede9fe; color: #6d28d9; font-size: 0.95rem; padding: 6px 12px;">Sedang Diproses (Processed)</span>
        @elseif($order->status === 'shipped')
          <span class="badge" style="background: #e0e7ff; color: #3730a3; font-size: 0.95rem; padding: 6px 12px;">Dalam Pengiriman (Shipped)</span>
        @elseif($order->status === 'completed')
          <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 0.95rem; padding: 6px 12px;">Selesai (Completed)</span>
        @elseif($order->status === 'cancelled')
          <span class="badge cancelled" style="font-size: 0.95rem; padding: 6px 12px;">Dibatalkan (Cancelled)</span>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="checkout-layout">
  <div>
    <div class="card table-scroll">
      <h3>Daftar Produk yang Dipesan</h3>
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
          @foreach($order->items as $item)
          <tr>
            <td><strong>{{ $item->product_name }}</strong></td>
            <td>Rp{{ number_format($item->price, 2, ',', '.') }}</td>
            <td>{{ $item->quantity }}</td>
            <td><strong>Rp{{ number_format($item->subtotal, 2, ',', '.') }}</strong></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="card">
      <h3>Informasi Pengiriman</h3>
      <p><strong>Penerima:</strong> {{ $order->recipient_name }}</p>
      <p><strong>Nomor Telepon:</strong> {{ $order->phone }}</p>
      <p><strong>Alamat:</strong> {{ $order->address }}</p>
      <p style="margin-top: 8px;"><strong>Layanan Ekspedisi:</strong> {{ $order->shipping_courier }} - {{ $order->shipping_service }} (Estimasi: {{ $order->shipping_eta }})</p>
    </div>
  </div>

  <div>
    <div class="card">
      <h3>Rincian Pembayaran</h3>

      <div class="summary-line">
        <span>Subtotal Produk</span>
        <span>Rp{{ number_format($order->subtotal, 2, ',', '.') }}</span>
      </div>

      <div class="summary-line">
        <span>Ongkos Kirim</span>
        <span>Rp{{ number_format($order->shipping_cost, 2, ',', '.') }}</span>
      </div>

      <hr style="margin: 12px 0; border: none; border-top: 1px solid var(--border);">

      <div class="summary-line summary-total">
        <span>Total Bayar</span>
        <span>Rp{{ number_format($order->grand_total, 2, ',', '.') }}</span>
      </div>
    </div>
  </div>
</div>
@endsection