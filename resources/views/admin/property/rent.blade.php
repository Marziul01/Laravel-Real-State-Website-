@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom-1">
                <h5 class="mb-0">Rent Properties</h5>
                @if ($access->rent_property == 3)
                <a href="{{ route('property.create') }}" class="btn btn-primary">Add New Property</a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Property Type</th>
                                <th>Name</th>
                                <th width="400px">Description</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Rent Starts</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center flex-column align-items-center auth-success-modal">
                    <img src="{{ asset('admin-assets/img/double-check.gif') }}" width="25%" alt="">
                    <h5 class="modal-title text-center" id="successModalLabel">Success</h5>
                    <p id="successMessage" class="text-center">Login successful!</p>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    @if ($property->isNotEmpty())
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('property.index') }}",
                    pageLength: 25,
                    lengthMenu: [[25, 50, 100], [25, 50, 100]],
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            text: 'Export CSV',
                            className: 'btn btn-sm my-custom-table-btn',
                            exportOptions: { columns: ':not(:last-child)' }
                        },
                        {
                            extend: 'print',
                            text: 'Print Table',
                            className: 'btn btn-sm my-custom-table-btn',
                            exportOptions: { columns: ':not(:last-child)' }
                        }
                    ],
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Sl
                        { data: 'image', name: 'images', orderable: false, searchable: false },
                        { data: 'property_type', name: 'propertyType.name', orderable: false, searchable: false },
                        { data: 'name', name: 'name' },
                        { data: 'description', name: 'description' },
                        { data: 'price', name: 'price' },
                        { data: 'location', name: 'city' }, // searching by city works, can customize if needed
                        { data: 'rent_start', name: 'rent_start' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    order: [[7, 'desc']], // order by Rent Starts
                    // language: {
                    //     processing: '<div class="loader-custom-wrapper"><div class="loader-custom1"></div></div>'
                    // }
                });
            });
        </script>

    @endif


    <script>
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();

            const form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>

@endsection
