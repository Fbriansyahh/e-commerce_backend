@extends('layout.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Daftar Produk</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form pencarian --}}
    <form action="{{ route('users.home') }}" method="GET" class="mb-4 d-flex" role="search">
        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control me-2" placeholder="Cari produk...">
        <button type="submit" class="btn btn-outline-primary">Cari</button>
    </form>

    {{-- List produk --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($products as $product)
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Form tambah ke keranjang --}}
                    <form action="{{ route('cart.index') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="d-flex align-items-center">
                            <input type="number" name="quantity" value="1" min="1" class="form-control me-2" style="width: 80px;">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">Produk tidak ditemukan.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection