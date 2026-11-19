@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->code)

@section('content')
<div class="section-heading">
  <div>
    <span class="eyebrow">PENGELOLAAN TRANSAKSI</span>
    <h1>Pesanan #{{ $order->code }}</h1>
  </div>
  <a class="btn-light" href="{{ route('admin.orders.index') }}">← Kembali ke Daftar Transaksi</a>
</div>

<div class="card" style="margin-bottom: 20px;">
  <div class="row" style="justify-content: space-between; align-items: center;">
    <div>
      <span class="muted" style="font-size: 0.85rem;">Tanggal Pemesanan:</span>
      <p style="font-weight: 600;">{{ $order->ordered_at ? $order->ordered_at->format('d F Y, H:i') : $order->created_at->format('d F Y, H:i') }} WIB</p>
      @if($order->validated_at)
        <span class="muted" style="font-size: 0.82rem; color: #047857;">
          ✓ Tervalidasi oleh {{ $order->validator?->name ?? 'Admin' }} pada {{ $order->validated_at->format('d M Y H:i') }} WIB
        </span>
      @endif
    </div>
    <div>
      <span class="muted" style="font-size: 0.85rem;">Status Saat Ini:</span>
      <div>
        @if($order->status === 'pending')
          <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 0.95rem; padding: 6px 12px;">Pending (Menunggu Validasi)</span>
        @elseif($order->status === 'confirmed')
          <span class="badge" style="background: #e0f2fe; color: #0369a1; font-size: 0.95rem; padding: 6px 12px;">Confirmed (Tervalidasi)</span>
        @elseif($order->status === 'processed')
          <span class="badge" style="background: #ede9fe; color: #6d28d9; font-size: 0.95rem; padding: 6px 12px;">Processed (Sedang Diproses)</span>
        @elseif($order->status === 'shipped')
          <span class="badge" style="background: #e0e7ff; color: #3730a3; font-size: 0.95rem; padding: 6px 12px;">Shipped (Dalam Pengiriman)</span>
        @elseif($order->status === 'completed')
          <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 0.95rem; padding: 6px 12px;">Completed (Pesanan Selesai)</span>
        @elseif($order->status === 'cancelled')
          <span class="badge cancelled" style="font-size: 0.95rem; padding: 6px 12px;">Cancelled (Pesanan Dibatalkan)</span>
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
            <td>
              <strong>{{ $item->product_name }}</strong>
              @if($item->product)
                <br><span class="muted" style="font-size: 0.8rem;">SKU: {{ $item->product->sku }} · Sisa Stok: {{ $item->product->stock }}</span>
              @endif
            </td>
            <td>Rp{{ number_format($item->price, 2, ',', '.') }}</td>
            <td>{{ $item->quantity }}</td>
            <td><strong>Rp{{ number_format($item->subtotal, 2, ',', '.') }}</strong></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="card">
      <h3>Informasi Penerima & Pengiriman</h3>
      <p><strong>Nama Penerima:</strong> {{ $order->recipient_name }} (Akun: {{ $order->user?->name ?? '-' }})</p>
      <p><strong>Nomor Telepon:</strong> {{ $order->phone }}</p>
      <p><strong>Alamat Pengiriman:</strong> {{ $order->address }}</p>
      <p style="margin-top: 8px;"><strong>Ekspedisi:</strong> {{ $order->shipping_courier }} - {{ $order->shipping_service }} (Estimasi: {{ $order->shipping_eta }})</p>
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
        <span>Total Tagihan</span>
        <span>Rp{{ number_format($order->grand_total, 2, ',', '.') }}</span>
      </div>
    </div>

    <div class="card">
      <h3>Aksi Pengelolaan</h3>

      @if($order->status === 'pending')
        <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn" style="width: 100%; padding: 10px; margin-bottom: 12px; background: #059669;">
            ✓ Validasi & Konfirmasi Pesanan
          </button>
        </form>
      @endif

      @if(in_array($order->status, ['confirmed', 'processed', 'shipped']))
        <form method="POST" action="{{ route('admin.orders.status', $order) }}" style="margin-bottom: 12px;">
          @csrf
          @method('PATCH')
          <label>Update Status Alur:
            <select name="status" style="margin-bottom: 8px;">
              <option value="processed" {{ $order->status === 'processed' ? 'selected' : '' }}>Diproses (Processed)</option>
              <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim (Shipped)</option>
              <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
            </select>
          </label>
          <button type="submit" class="btn" style="width: 100%; padding: 10px;">
            Update Status Pesanan ↗
          </button>
        </form>
      @endif

      @if(!in_array($order->status, ['cancelled', 'completed']))
        <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn-danger" style="width: 100%; padding: 10px; font-size: 0.9rem;" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Stok produk akan otomatis dikembalikan (rollback).')">
            ✕ Batalkan Pesanan (Rollback Stok)
          </button>
        </form>
      @endif

      @if($order->status === 'completed')
        <p style="color: #059669; font-weight: 600; text-align: center; margin-top: 8px;">✓ Pesanan telah selesai.</p>
      @elseif($order->status === 'cancelled')
        <p style="color: #dc2626; font-weight: 600; text-align: center; margin-top: 8px;">✕ Pesanan telah dibatalkan.</p>
      @endif
    </div>
  </div>
</div>
@endsection