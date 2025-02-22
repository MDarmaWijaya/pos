@extends('layouts.admin')

@section('title', __('product.Product_List'))
@section('content-header', __('product.Product_List'))
@section('content-actions')
<a href="{{route('products.create')}}" class="btn btn-primary">{{ __('product.Create_Product') }}</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<style>
    /* Tambahkan CSS untuk responsivitas */
    @media (max-width: 767.98px) {
        .product-img {
            width: 50px; /* Ukuran gambar lebih kecil di mobile */
            height: auto;
        }
        .table th, .table td {
            padding: 0.5rem; /* Padding lebih kecil di mobile */
        }
        .table thead {
            display: none; /* Sembunyikan header di mobile */
        }
        .table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
        }
        .table td {
            display: block;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }
        .table td::before {
            content: attr(data-label); /* Tambahkan label dari data-label */
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
        .table td:last-child {
            border-bottom: 0;
        }
    }
</style>
@endsection
@section('content')
<div class="card product-list">
    <div class="card-body">
        <div class="table-responsive"> <!-- Bungkus tabel dengan table-responsive -->
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('product.ID') }}</th>
                        <th>{{ __('product.Name') }}</th>
                        <th>{{ __('product.Image') }}</th>
                        <th class="d-none d-md-table-cell">{{ __('product.Barcode') }}</th> <!-- Sembunyikan di mobile -->
                        <th>{{ __('product.Price') }}</th>
                        <th>{{ __('product.Quantity') }}</th>
                        <th>{{ __('product.Status') }}</th>
                        <th class="d-none d-md-table-cell">{{ __('product.Created_At') }}</th> <!-- Sembunyikan di mobile -->
                        <th class="d-none d-md-table-cell">{{ __('product.Updated_At') }}</th> <!-- Sembunyikan di mobile -->
                        <th>{{ __('product.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td data-label="{{ __('product.ID') }}">{{$product->id}}</td>
                        <td data-label="{{ __('product.Name') }}">{{$product->name}}</td>
                        <td data-label="{{ __('product.Image') }}">
                            <img class="product-img" src="{{ Storage::url($product->image) }}" alt="">
                        </td>
                        <td class="d-none d-md-table-cell" data-label="{{ __('product.Barcode') }}">{{$product->barcode}}</td>
                        <td data-label="{{ __('product.Price') }}">{{$product->price}}</td>
                        <td data-label="{{ __('product.Quantity') }}">{{$product->quantity}}</td>
                        <td data-label="{{ __('product.Status') }}">
                            <span class="right badge badge-{{ $product->status ? 'success' : 'danger' }}">{{$product->status ? __('common.Active') : __('common.Inactive') }}</span>
                        </td>
                        <td class="d-none d-md-table-cell" data-label="{{ __('product.Created_At') }}">{{$product->created_at}}</td>
                        <td class="d-none d-md-table-cell" data-label="{{ __('product.Updated_At') }}">{{$product->updated_at}}</td>
                        <td data-label="{{ __('product.Actions') }}">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger btn-sm btn-delete" data-url="{{route('products.destroy', $product)}}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->render() }}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="module">
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
            var $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: '{{ __('product.sure') }}',
                text: '{{ __('product.really_delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('product.yes_delete') }}',
                cancelButtonText: '{{ __('product.No') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    }, function(res) {
                        $this.closest('tr').fadeOut(500, function() {
                            $(this).remove();
                        });
                    });
                }
            });
        });
    });
</script>
@endsection