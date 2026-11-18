@extends('layouts.admin')

@section('title','Ekspedisi')

@section('content')
<h1>Layanan Ekspedisi</h1>

<div class="card">
  <form method="POST" action="{{ route('admin.shipping.store') }}">
    @csrf
    <div class="row">
      <label style="flex:1">Kurir
        <input class="input" name="courier" required placeholder="Contoh: JNE">
      </label>
      <label style="flex:1">Layanan
        <input class="input" name="service" required placeholder="Contoh: REG">
      </label>
      <label style="flex:1">Estimasi (ETA)
        <input class="input" name="eta" placeholder="Contoh: 2-3 hari">
      </label>
      <label style="flex:1">Biaya (Rp)
        <input class="input" type="number" step="0.01" name="cost" min="0" required placeholder="Contoh: 15000">
      </label>
      <label style="display:flex;align-items:center;gap:6px;margin-top:20px;">
        <input type="checkbox" name="is_active" value="1" checked> Aktif
      </label>
      <button class="btn" style="margin-top:20px;">Tambah Ekspedisi</button>
    </div>
  </form>
</div>

<div class="card">
  <div class="table-scroll">
    <table>
      <thead>
        <tr>
          <th>Kurir</th>
          <th>Layanan</th>
          <th>Estimasi</th>
          <th>Biaya</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $service)
        <tr>
          <td><strong>{{ $service->courier }}</strong></td>
          <td>{{ $service->service }}</td>
          <td>{{ $service->eta ?? '-' }}</td>
          <td>Rp{{ number_format($service->cost, 2, ',', '.') }}</td>
          <td>
            <span class="badge" style="background:{{ $service->is_active ? '#dcfce7;color:#166534' : '#fee2e2;color:#991b1b' }}">
              {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
          </td>
          <td>
            <form method="POST" action="{{ route('admin.shipping.destroy', $service) }}" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn-danger" onclick="return confirm('Nonaktifkan layanan ini?')">Nonaktifkan</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection