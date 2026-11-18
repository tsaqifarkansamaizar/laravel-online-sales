@extends('layouts.admin')

@section('title','Kategori')

@section('content')
<h1>Kategori</h1>

<div class="card">
  <form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <label>Nama Kategori
      <input class="input" name="name" required placeholder="Contoh: Elektronik">
    </label>
    <button class="btn" style="margin-top:8px;">Tambah Kategori</button>
  </form>
</div>

<div class="card">
  <div class="table-scroll">
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Jumlah Produk</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td>
            <form class="row" method="POST" action="{{ route('admin.categories.update',$category) }}">
              @csrf
              @method('PUT')
              <input class="input" style="max-width:240px" name="name" value="{{ $category->name }}">
              <button class="btn">Simpan</button>
            </form>
          </td>
          <td>{{ $category->products_count }}</td>
          <td>
            <form method="POST" action="{{ route('admin.categories.destroy',$category) }}">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection