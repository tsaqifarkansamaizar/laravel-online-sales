@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
<div class="section-heading">
  <h1>Daftar Transaksi Pesanan</h1>
</div>

<div class="card" style="margin-bottom: 16px;">
  <form method="GET" action="{{ route('admin.orders.index') }}" class="row" style="gap: 12px; align-items: flex-end;">
    <div style="flex: 1; min-width: 200px;">
      <label style="margin-bottom: 0;">Filter Berdasarkan Status:
        <select name="status" onchange="this.form.submit()">
          <option value="">-- Semua Status --</option>
          <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending (Menunggu Validasi)</option>
          <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed (Tervalidasi)</option>
          <option value="processed" {{ $status === 'processed' ? 'selected' : '' }}>Processed (Diproses)</option>
          <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
          <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
          <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
        </select>
      </label>
    </div>
    @if($status)
      <a class="btn-light" href="{{ route('admin.orders.index') }}">Reset Filter</a>
    @endif
  </form>
</div>

<div class="card table-scroll">
  @if($orders->isEmpty())
    <p class="muted">Tidak ada data transaksi pesanan.</p>
  @else
    <table>
      <thead>
        <tr>
          <th>Kode Pesanan</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Pengiriman</th>
          <th>Total Bayar</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
        <tr>
          <td><strong>#{{ $order->code }}</strong></td>
          <td>{{ $order->ordered_at ? $order->ordered_at->format('d M Y H:i') : $order->created_at->format('d M Y H:i') }}</td>
          <td>
            <strong>{{ $order->recipient_name }}</strong><br>
            <span class="muted" style="font-size: 0.82rem;">{{ $order->phone }}</span>
          </td>
          <td>{{ $order->shipping_courier }} - {{ $order->shipping_service }}</td>
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
            <a class="btn" href="{{ route('admin.orders.show', $order) }}">Kelola ↗</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@if($orders->hasPages())
  <div style="margin-top: 16px;">
    {{ $orders->links('pagination.default') }}
  </div>
@endif
@endsection