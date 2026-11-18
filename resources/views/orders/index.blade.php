@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="section-heading">
  <h1>Riwayat Pesanan Saya</h1>
  <a class="btn-light" href="{{ route('shop.index') }}">← Belanja Lagi</a>
</div>

@if($orders->isEmpty())
  <div class="card">
    <p class="muted">Anda belum memiliki riwayat pesanan.</p>
    <a class="btn" href="{{ route('shop.index') }}" style="margin-top: 12px;">Mulai Belanja ↗</a>
  </div>
@else
  <div class="card table-scroll">
    <table>
      <thead>
        <tr>
          <th>Kode Pesanan</th>
          <th>Tanggal</th>
          <th>Penerima</th>
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
            <span class="muted" style="font-size: 0.82rem;">{{ Str::limit($order->address, 30) }}</span>
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
            <a class="btn-light" href="{{ route('orders.show', $order) }}">Detail ↗</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if($orders->hasPages())
    <div style="margin-top: 16px;">
      {{ $orders->links('pagination.default') }}
    </div>
  @endif
@endif
@endsection