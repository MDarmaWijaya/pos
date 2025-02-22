@extends('layouts.admin')

@section('title', __('Supplier List'))
@section('content-header', __('Supplier List'))
@section('content-actions')
<a href="{{route('suppliers.create')}}" class="btn btn-primary">{{ __('Add Supplier') }}</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<style>
    /* Tambahkan CSS untuk responsivitas */
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: auto; /* Aktifkan scroll horizontal */
        }
        .table th, .table td {
            white-space: nowrap; /* Mencegah teks dari wrapping */
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
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('First Name') }}</th>
                        <th>{{ __('Last Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{$supplier->id}}</td>
                        <td>{{$supplier->first_name}}</td>
                        <td>{{$supplier->last_name}}</td>
                        <td>{{$supplier->email}}</td>
                        <td>{{$supplier->phone}}</td>
                        <td>{{$supplier->address}}</td>
                        <td>{{$supplier->created_at}}</td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-delete" data-url="{{route('suppliers.destroy', $supplier)}}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $suppliers->render() }}
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
                title: '{{ __("Are you sure?") }}',
                text: '{{ __("You won\'t be able to revert this!") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __("Yes, delete it!") }}',
                cancelButtonText: '{{ __("No, cancel!") }}',
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