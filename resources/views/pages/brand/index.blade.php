@extends('layouts.app')

@push('header')
    <!-- Include DataTables styles -->
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="mb-0">Brand Management</p>

<<<<<<< HEAD
                    <a class="btn btn-sm btn-primary ms-auto" title="Creat brand"
                        data-url="{{ route('brands.create') }}" data-size="small" data-ajax-popup="true"
                        data-title="{{ __('Create New Brand') }}" data-bs-toggle="tooltip">
                        Add New
                    </a>
=======
                    <div class="d-flex align-items-end ms-auto">
                        <div class="form-check form-switch me-3">
                            <label class="form-check-label" for="showTrashed">Show Trashed items</label>
                            <input class="form-check-input" type="checkbox" id="showTrashed" />
                        </div>
                        <a class="btn btn-sm btn-primary" title="Create brand" data-url="{{ route('brands.create') }}"
                            data-size="small" data-ajax-popup="true" data-title="{{ __('Create New Brand') }}"
                            data-bs-toggle="tooltip">
                            Add New
                        </a>
                    </div>
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
                </div>
                <div class="card-body">
                    <!-- Table for brands -->
                    <table class="table table-bordered table-striped" id="brand-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Items Count</th>
                                <th>Models Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamically populated by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include DataTables scripts -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
<<<<<<< HEAD
            $('#brand-table').DataTable({
=======
            var table = $('#brand-table').DataTable({
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
                'paging': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                'responsive': true,
                'ajax': {
<<<<<<< HEAD
                    'url': '{{ route('brands.show') }}',  // Fetch the brand data from server
                    
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'items', name: 'items' },
                    { data: 'models', name: 'models' },
=======
                    'url': '{{ route('brands.show') }}',
                    'data': function(d) {
                        d.show_trashed = $('#showTrashed').prop('checked');
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'items',
                        name: 'items'
                    },
                    {
                        data: 'models',
                        name: 'models'
                    },
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
<<<<<<< HEAD
                        searchable: false,
=======
                        searchable: false
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
<<<<<<< HEAD
        });

        // Delete Confirmation with SweetAlert
        function Delete(brandId) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success py-2 px-4",
                    cancelButton: "btn btn-danger mx-4 py-2 px-4"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to delete the brand
                    $.ajax({
                        url: '{{ route('brands.destroy', '') }}' + '/' + brandId,
                        method: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(result) {
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!",
                                text: "Brand has been deleted.",
                                icon: "success",
                                timer: 2000
                            });
                            // Reload the table after deletion
                            location.reload();
                        },
                        error: function(jqXHR, exception) {
                            toastr.error('Failed to delete brand');
                        }
                    });
                }
            });
        }
=======

            $('#showTrashed').change(function() {
                table.draw();
            });

            window.handleAction = function(brandId, actionType) {
                let title, text, icon, url, method, successMessage;

                switch (actionType) {
                    case 'restore':
                        title = "Are you sure?";
                        text = "You want to restore this brand!";
                        icon = "info";
                        url = '{{ route('brands.restore', '') }}';
                        method = 'POST';
                        successMessage = "Brand has been restored.";
                        break;

                    case 'permanentDelete':
                        title = "Are you sure?";
                        text = "This action will permanently delete the brand. You won't be able to revert it!";
                        icon = "warning";
                        url = '{{ route('brands.forceDelete', '') }}';
                        method = 'DELETE';
                        successMessage = "Brand has been permanently deleted.";
                        break;
                    case 'delete':

                        title = "Are you sure?";
                        text = "This action will move this Brand to trash.";
                        icon = "warning";
                        url = '{{ route('brands.destroy', '') }}';
                        method = 'GET';
                        successMessage = "Brand has been moved to trash.";
                        break;
                }

                swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success py-2 px-4",
                        cancelButton: "btn btn-danger mx-4 py-2 px-4"
                    },
                    buttonsStyling: false
                }).fire({
                    title,
                    text,
                    icon,
                    showCancelButton: true,
                    confirmButtonText: "Yes, proceed!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `${url}/${brandId}`,
                            method: method,
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                swal.fire({
                                    title: successMessage,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                                table.ajax.reload();
                            },
                            error: function() {
                                toastr.error('Action failed');
                            }
                        });
                    }
                });
            };
        });
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
    </script>
@endpush
