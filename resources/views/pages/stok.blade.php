<!-- resources/views/pages/stok.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Stok</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add New Stok Form -->
    <form action="{{ route('stok.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select class="form-control" id="kategori_id" name="kategori_id" required>
                <option value="">Select Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="barang_id" class="form-label">Barang</label>
            <select class="form-control" id="barang_id" name="barang_id" required>
                <option value="">Select Barang</option>
                @foreach($barang as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input type="number" class="form-control" id="harga_beli" name="harga_beli" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Stok</button>
    </form>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('stok.index') }}" class="mb-4 mt-3">
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="search" class="form-control" placeholder="Search by nama barang" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Filter by status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="kategori_id" class="form-control">
                    <option value="">Filter by Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('kategori_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="stok_availability" class="form-control">
                    <option value="">Filter by stok availability</option>
                    <option value="available" {{ request('stok_availability') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="empty" {{ request('stok_availability') == 'empty' ? 'selected' : '' }}>Empty</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-2 mt-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Stok Table -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori</th>
                <th>Barang</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stok as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->kategori->nama }}</td>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ 'Rp ' . number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="keterangan-cell">{{ $item->keterangan }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->status ? 'Active' : 'Disabled' }}</td>
                    <td>
                        <!-- Toggle Status Form -->
                        <form action="{{ route('stok.toggleStatus', $item) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-warning">
                                {{ $item->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <!-- Edit Form -->
                        <button class="btn btn-sm btn-info" onclick="editStok({{ $item }})">Edit</button>

                        <!-- Delete Form -->
                        <form action="{{ route('stok.destroy', $item) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $stok->appends(request()->input())->links() }}
</div>

<!-- Edit Stok Modal -->
<div class="modal fade" id="editStokModal" tabindex="-1" aria-labelledby="editStokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="editStokForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStokModalLabel">Edit Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editKategoriId" class="form-label">Kategori</label>
                        <select class="form-control" id="editKategoriId" name="kategori_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editBarangId" class="form-label">Barang</label>
                        <select class="form-control" id="editBarangId" name="barang_id" required>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="editStok" name="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="editHargaBeli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="editHargaBeli" name="harga_beli" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editKeterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="editKeterangan" name="keterangan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editTanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function editStok(stok) {
        document.getElementById('editKategoriId').value = stok.kategori_id;
        document.getElementById('editBarangId').value = stok.barang_id;
        document.getElementById('editStok').value = stok.stok;
        document.getElementById('editHargaBeli').value = stok.harga_beli;
        document.getElementById('editKeterangan').value = stok.keterangan;
        document.getElementById('editTanggal').value = stok.tanggal;
        document.getElementById('editStatus').value = stok.status;
        document.getElementById('editStokForm').action = '/stok/' + stok.id;
        var editStokModal = new bootstrap.Modal(document.getElementById('editStokModal'));
        editStokModal.show();
    }
</script>

<!-- Add this CSS to trim the keterangan and show ellipsis -->
<style>
    .keterangan-cell {
        max-width: 200px; /* Adjust the width as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection
