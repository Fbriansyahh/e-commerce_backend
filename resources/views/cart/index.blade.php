@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Keranjang Belanja</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <p>Keranjang Anda kosong.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                                </form>
                            </td>
                            <td>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('checkout.index') }}" class="btn btn-success">Lanjut ke Pembayaran</a>
        @endif
    </div>
@endsection
