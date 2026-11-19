@extends('layouts.admin')

@section('title', 'Ringkasan')

@section('content')
<h1>Ringkasan Toko</h1>

<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
  <div class="card" style="margin-bottom: 0;">
    <span class="eyebrow">TOTAL PRODUK</span>
    <h2 style="font-size: 2rem; margin: 8px 0;">{{ $totalProducts }}</h2>
    <span class="muted">Produk terdaftar</span>
  </div>

  <div class="card" style="margin-bottom: 0;">
    <span class="eyebrow">KATEGORI</span>
    <h2 style="font-size: 2rem; margin: 8px 0;">{{ $totalCategories }}</h2>
    <span class="muted">Kategori barang</span>
  </div>

  <div class="card" style="margin-bottom: 0;">
    <span class="eyebrow" style="color: #d97706;">PESANAN PENDING</span>
    <h2 style="font-size: 2rem; margin: 8px 0; color: #d97706;">{{ $pendingOrders }}</h2>
    <span class="muted">Perlu validasi admin</span>
  </div>

  <div class="card" style="margin-bottom: 0;">
    <span class="eyebrow" style="color: #059669;">TOTAL PENDAPATAN</span>
    <h2 style="font-size: 1.5rem; margin: 8px 0; color: #059669;">Rp{{ number_format($totalRevenue, 2, ',', '.') }}</h2>
    <span class="muted">{{ $totalOrders }} Total transaksi</span>
  </div>
</div>

<div class="card table-scroll">
  <div class="row" style="justify-content: space-between; align-items: center; margin-bottom: 12px;">
    <h3>Transaksi Pesanan Terbaru</h3>
    <a class="btn-light" href="{{ route('admin.orders.index') }}">Lihat Semua Transaksi ↗</a>
  </div>

  @if($recentOrders->isEmpty())
    <p class="muted">Belum ada transaksi pesanan.</p>
  @else
    <table>
      <thead>
        <tr>
          <th>Kode Pesanan</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Total Bayar</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentOrders as $order)
        <tr>
          <td><strong>#{{ $order->code }}</strong></td>
          <td>{{ $order->ordered_at ? $order->ordered_at->format('d M Y H:i') : $order->created_at->format('d M Y H:i') }}</td>
          <td>{{ $order->user?->name ?? $order->recipient_name }}</td>
          <td><strong style="color: #047857;">Rp{{ number_format($order->grand_total, 2, ',', '.') }}</strong></td>
          <td>
            @if($order->status === 'pending')
              <span class="badge" style="background: #fef3c7; color: #92400e;">Pending</span>
            @elseif($order->status === 'confirmed')
              <span class="badge" style="background: #e0f2fe; color: #0369a1;">Confirmed</span>
            @elseif($order->status === 'processed')
              <span class="badge" style="background: #ede9fe; color: #6d28d9;">Processed</span>
            @elseif($order->status === 'shipped')
              <span class="badge" style="background: #e0e7ff; color: #3730a3;">Shipped</span>
            @elseif($order->status === 'completed')
              <span class="badge" style="background: #dcfce7; color: #15803d;">Completed</span>
            @elseif($order->status === 'cancelled')
              <span class="badge cancelled">Cancelled</span>
            @else
              <span class="badge">{{ ucfirst($order->status) }}</span>
            @endif
          </td>
          <td>
            <a class="btn-light" href="{{ route('admin.orders.show', $order) }}">Kelola ↗</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection