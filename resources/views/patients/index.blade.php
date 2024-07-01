@extends('layouts.master')
@section('title', 'Hospitals')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Pasien</div>
            <div class="card-body">
                <div id="success-alert" class="alert alert-success" id="alert" style="display: none">
                    <span id="success-message"></span>
                </div>

                <div id="error-alert" class="alert alert-danger" id="alert" style="display: none">
                    <span id="error-message"></span>
                </div>

                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">
                    Tambah Data
                </button>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-inline">
                            <label for="paginate">Show</label>
                            <select name="paginate" id="paginate" class="form-control">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="hospital_id" id="search-hospital" class="form-control">
                            <option value="all">Pilih Rumah Sakit</option>
                            @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <form action="" method="GET">
                            <div class="form-group
                            ">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Cari data pasien">
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-bordered" id="hospital-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Rumah Sakit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    <div class="pagination mt-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Rumah Sakit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="modalStore">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" name="address" id="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="hospital">Pilih Rumah Sakit</label>
                        <select name="hospital_id" id="hospital" class="form-control">
                            @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Rumah Sakit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="PUT" id="modalUpdate">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name-edit" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" name="address" id="address-edit" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input type="text" name="phone" id="phone-edit" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="hospital">Pilih Rumah Sakit</label>
                        <select name="hospital_id" id="hospital-edit" class="form-control">
                            @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(window).on('load', function() {
        DataTable();

        $(document).on('click', '.page-link', function() {
            let page = $(this).data('page');
            DataTable(page);
        });

        $('#paginate').on('change', function() {
            let paginate = $(this).val();
            DataTable(1, paginate);
        });

        $('#search').on('keyup', function() {
            let search = $(this).val();
            DataTable(1, 5, search);
        });

        $('#search-hospital').on('change', function() {
            let hospital_id = $(this).val();
            DataTable(1, 5, null, hospital_id);
        });

        $('#modalStore').on('submit', function(e) {
            e.preventDefault();

            let name = $('#name').val();
            let address = $('#address').val();
            let phone = $('#phone').val();
            let hospital_id = $('#hospital').val();

            $.ajax({
                url: "{{ route('patients.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                    address: address,
                    phone: phone,
                    hospital_id: hospital_id
                },
                success: function(response) {
                    $('#success-alert').show();
                    $('#success-message').html(response.message);

                    setTimeout(function() {
                        $('#success-alert').hide();
                    }, 6000);

                    $('#modalStore')[0].reset();

                    $('#addModal').modal('hide');
                    DataTable();
                },
                error: function(xhr) {
                    $('#error-alert').show();
                    $('#error-message').html(xhr.responseJSON.message);

                    setTimeout(function() {
                        $('#error-alert').hide();
                    }, 6000);

                    $('#modalStore')[0].reset();

                    $('#addModal').modal('hide');
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('patient');

            $.ajax({
                url: `/patients/show/${id}`,
                type: "GET",
                success: function(response) {
                    $('#id').val(response.id);
                    $('#name-edit').val(response.name);
                    $('#address-edit').val(response.address);
                    $('#phone-edit').val(response.phone);
                    $('#hospital-edit').val(response.hospital_id);
                }
            });
        });

        $('#modalUpdate').on('submit', function(e) {
            e.preventDefault();

            let id = $('#id').val();
            let name = $('#name-edit').val();
            let address = $('#address-edit').val();
            let phone = $('#phone-edit').val();
            let hospital_id = $('#hospital-edit').val();

            $.ajax({
                url: `/patients/update/${id}`,
                type: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    name: name,
                    address: address,
                    phone: phone,
                    hospital_id: hospital_id
                },
                success: function(response) {
                    $('#success-alert').show();
                    $('#success-message').html(response.message);

                    setTimeout(function() {
                        $('#success-alert').hide();
                    }, 6000);

                    $('#modalUpdate')[0].reset();

                    $('#editModal').modal('hide');
                    DataTable();
                },
                error: function(xhr) {
                    $('#error-alert').show();
                    $('#error-message').html(xhr.responseJSON.message);

                    setTimeout(function() {
                        $('#error-alert').hide();
                    }, 6000);

                    $('#modalUpdate')[0].reset();

                    $('#editModal').modal('hide');
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('patient');

            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `/patients/delete/${id}`,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        $('#success-alert').show();
                        $('#success-message').html(response.message);

                        setTimeout(function() {
                            $('#success-alert').hide();
                        }, 6000);

                        DataTable();
                    }
                });
            }
        });
    });

    function DataTable(page = 1, paginate = 5, search = null, hospital_id = 'all') {
        $.ajax({
            url: "{{ route('patients.paginate') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                page: page,
                paginate: paginate,
                search: search,
                hospital_id: hospital_id
            },
            success: function(response) {
                let data = response.data;
                let html = '';

                if(data.length == 0) {
                    html += `
                        <tr>
                            <td colspan="6" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    `;
                }
                else {
                    data.forEach((item, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.name}</td>
                                <td>${item.address}</td>
                                <td>${item.phone}</td>
                                <td>${item.hospital.name}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-edit" data-toggle="modal" data-target="#editModal" data-patient="${item.id}">Edit</button>
                                    <button type="button" class="btn btn-danger btn-delete" data-patient="${item.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                }

                $('#hospital-table tbody').html(html);

                let pagination = response.links;
                let paginationHtml = '';
                let url = '';
                let pervious = '';
                let next = '';

                pagination.forEach((item, index) => {

                    if (item.url == null) {
                        url = '#';
                    } else {
                        url = item.url;
                    };

                    if (item.active) {
                        paginationHtml += `<button class="page-link bg-primary text-white" data-page="${item.label}">${item.label}</a>`;
                    } else {
                        if (item.label == '&laquo; Previous') {
                            paginationHtml += `<button class="page-link" data-page="${pagination[1].label}">${item.label}</a>`;
                        } else if (item.label == 'Next &raquo;') {
                            paginationHtml += `<button class="page-link" data-page="${pagination[pagination.length - 2].label}">${item.label}</a>`;
                        } else {
                            paginationHtml += `<button class="page-link" data-page="${item.label}">${item.label}</a>`;
                        }
                    }
                });

                $('.pagination').html(paginationHtml);
            }
        });

    }
</script>