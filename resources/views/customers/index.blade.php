@extends('layouts.admin')

@section('title', __('customer.Customer_List'))
@section('content-header', __('customer.Customer_List'))
@section('content-actions')
<a href="{{route('customers.create')}}" class="btn btn-primary">{{ __('customer.Add_Customer') }}</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<style>
    /* Tambahkan CSS untuk responsivitas */
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: auto; /* Aktifkan scroll horizontal */
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
        .table img {
            width: 40px; /* Ukuran gambar lebih kecil di mobile */
            height: auto;
        }
        .btn {
            padding: 0.25rem 0.5rem; /* Tombol lebih kecil di mobile */
            font-size: 0.875rem;
        }
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive"> <!-- Bungkus tabel dengan table-responsive -->
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('customer.ID') }}</th>
                        <th>{{ __('customer.Avatar') }}</th>
                        <th>{{ __('customer.First_Name') }}</th>
                        <th>{{ __('customer.Last_Name') }}</th>
                        <th class="d-none d-md-table-cell">{{ __('customer.Email') }}</th> <!-- Sembunyikan di mobile -->
                        <th class="d-none d-md-table-cell">{{ __('customer.Phone') }}</th> <!-- Sembunyikan di mobile -->
                        <th class="d-none d-md-table-cell">{{ __('customer.Address') }}</th> <!-- Sembunyikan di mobile -->
                        <th class="d-none d-md-table-cell">{{ __('common.Created_At') }}</th> <!-- Sembunyikan di mobile -->
                        <th>{{ __('customer.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td data-label="{{ __('customer.ID') }}">{{$customer->id}}</td>
                        <td data-label="{{ __('customer.Avatar') }}">
                            <img width="50" src="{{$customer->getAvatarUrl()}}" alt="">
                        </td>
                        <td data-label="{{ __('customer.First_Name') }}">{{$customer->first_name}}</td>
                        <td data-label="{{ __('customer.Last_Name') }}">{{$customer->last_name}}</td>
                        <td class="d-none d-md-table-cell" data-label="{{ __('customer.Email') }}">{{$customer->email}}</td>
                        <td class="d-none d-md-table-cell" data-label="{{ __('customer.Phone') }}">{{$customer->phone}}</td>
                        <td class="d-none d-md-table-cell" data-label="{{ __('customer.Address') }}">{{$customer->address}}</td>
                        <td class="d-none d-md-table-cell" data-label="{{ __('common.Created_At') }}">{{$customer->created_at}}</td>
                        <td data-label="{{ __('customer.Actions') }}">
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger btn-sm btn-delete" data-url="{{route('customers.destroy', $customer)}}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $customers->render() }}
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
            });

            swalWithBootstrapButtons.fire({
                title: '{{ __('customer.sure') }}',
                text: '{{ __('customer.really_delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('customer.yes_delete') }}',
                cancelButtonText: '{{ __('customer.No') }}',
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