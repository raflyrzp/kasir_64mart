@extends('layout/main');

@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Suppliers</h3>
                    <p class="text-subtitle text-muted">
                        A list of suppliers.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href='/{{ $role }}'>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Suppliers
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">Add Supplier</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($role . '.supplier.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama_supplier">Supplier name</label>
                                                <input type="text" id="nama_supplier" class="form-control"
                                                    placeholder="Supplier name..." name="nama_supplier">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="alamat">Address</label>
                                                <input type="text" id="alamat" class="form-control"
                                                    placeholder="Address..." name="alamat">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="telp">Telp</label>
                                                <input type="text" id="telp" class="form-control"
                                                    placeholder="Telp..." name="telp">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Supplier Table</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Supplier name</th>
                                    <th>Address</th>
                                    <th>Telp</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_supplier as $i => $supplier)
                                    <tr>
                                        <td class="col-1">{{ $i + 1 }}</td>
                                        <td>{{ $supplier->nama_supplier }}</td>
                                        <td>{{ $supplier->alamat }}</td>
                                        <td>{{ $supplier->telp }}</td>
                                        <td class="col-2">
                                            <button type="button" class="btn btn-sm btn-primary col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $supplier->id }}">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $supplier->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal untuk Edit -->
        @foreach ($data_supplier as $supplier)
            <div class="modal fade" id="editModal{{ $supplier->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel{{ $supplier->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editModalLabel{{ $supplier->id }}">Edit Supplier</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form action="{{ route($role . '.supplier.update', $supplier->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <label for="nama_supplier">Supplier name</label>
                                <div class="form-group">
                                    <input id="nama_supplier" name="nama_supplier" type="text"
                                        placeholder="Supplier name..." class="form-control"
                                        value="{{ $supplier->nama_supplier }}">
                                </div>

                                <label for="alamat">Address</label>
                                <div class="form-group">
                                    <input id="alamat" name="alamat" type="text" placeholder="Address..."
                                        class="form-control" value="{{ $supplier->alamat }}">
                                </div>

                                <label for="telp">Telp</label>
                                <div class="form-group">
                                    <input id="telp" name="telp" type="text" placeholder="Telp..."
                                        class="form-control" value="{{ $supplier->telp }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $supplier->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $supplier->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Delete Product
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Are you sure you want to delete this Supplier?
                            </p>
                            <p>
                                Supplier name : {{ $supplier->nama_supplier }}
                            </p>
                            <p>
                                Address : {{ $supplier->alamat }}
                            </p>
                            <p>
                                Telp : {{ $supplier->telp }}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>

                            <form action="{{ route($role . '.supplier.destroy', $supplier->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-1">
                                    Delete
                                </button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
