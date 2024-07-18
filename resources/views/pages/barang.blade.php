<!-- resources/views/pages/barang.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Barang</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add New Barang Form -->
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select class="form-control" id="kategori_id" name="kategori_id" required>
                <option value="">Select Kategori</option>
                @foreach($categories as $category)
                    @if($category->status == 1)
                        <option value="{{ $category->id }}">{{ $category->nama }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Barang</button>
    </form>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('barang.index') }}" class="mb-4 mt-3">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Filter by status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="kategori_id" class="form-control">
                    <option value="">Filter by Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('kategori_id') == $category->id ? 'selected' : '' }}>{{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Barang Table -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategori</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->kategori->nama }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->status ? 'Active' : 'Disabled' }}</td>
                    <td>
                        <!-- Toggle Status Form -->
                        <form action="{{ route('barang.toggleStatus', $item) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-warning">
                                {{ $item->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <!-- Edit Form -->
                        <button class="btn btn-sm btn-info" onclick="editBarang({{ $item }})">Edit</button>

                        <!-- Delete Form -->
                        <form action="{{ route('barang.destroy', $item) }}" method="POST" style="display:inline;">
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
    {{ $barang->appends(request()->input())->links() }}
</div>

<!-- Edit Barang Modal -->
<div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="editBarangForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
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
                        <label for="editNama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDeskripsi" name="deskripsi"></textarea>
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
    function editBarang(barang) {
        document.getElementById('editKategoriId').value = barang.kategori_id;
        document.getElementById('editNama').value = barang.nama;
        document.getElementById('editDeskripsi').value = barang.deskripsi;
        document.getElementById('editStatus').value = barang.status;
        document.getElementById('editBarangForm').action = '/barang/' + barang.id;
        var editBarangModal = new bootstrap.Modal(document.getElementById('editBarangModal'));
        editBarangModal.show();
    }
</script>
@endsection
