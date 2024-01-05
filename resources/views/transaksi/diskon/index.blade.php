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
                    <h3>Discounts</h3>
                    <p class="text-subtitle text-muted">
                        A role that can access all menus.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href='/{{ $role }}'>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Discounts
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
                            <h4 class="card-title">Add Discount</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($role . '.diskon.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama_diskon">Discount name</label>
                                                <input type="text" id="nama_diskon" class="form-control" placeholder=""
                                                    name="nama_diskon" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="besar_diskon">Discount Amount</label>
                                                <input type="number" id="besar_diskon" class="form-control" placeholder=""
                                                    name="besar_diskon" required>
                                                <small>*just write down the discount number</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tanggal_mulai">Start date</label>
                                                <input type="date" id="tanggal_mulai" class="form-control"
                                                    name="tanggal_mulai" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tanggal_berakhir">End date</label>
                                                <input type="date" id="tanggal_berakhir" class="form-control"
                                                    name="tanggal_berakhir" placeholder="">
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
                    <h5 class="card-title">Discount Table</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Discount name</th>
                                    <th>Discount amount</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_diskon as $i => $diskon)
                                    <tr>
                                        <td class="col-1">{{ $i + 1 }}</td>
                                        <td>{{ $diskon->nama_diskon }}</td>
                                        <td>{{ $diskon->besar_diskon }}%</td>
                                        <td class="{{ $diskon->tanggal_mulai > now() ? 'text-danger' : '' }}">
                                            {{ $diskon->tanggal_mulai }}</td>
                                        <td class="{{ $diskon->tanggal_berakhir < now() ? 'text-danger' : '' }}">
                                            {{ $diskon->tanggal_berakhir }}</td>
                                        <td class="col-2">
                                            <button type="button" class="btn btn-sm btn-primary col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $diskon->id }}">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $diskon->id }}">Delete</button>
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
        @foreach ($data_diskon as $diskon)
            <div class="modal fade" id="editModal{{ $diskon->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel{{ $diskon->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editModalLabel{{ $diskon->id }}">Edit discount</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form action="{{ route($role . '.diskon.update', $diskon->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <label for="nama_diskon">Name</label>
                                <div class="form-group">
                                    <input id="nama_diskon" name="nama_diskon" type="text"
                                        placeholder="Discount name..." class="form-control"
                                        value="{{ $diskon->nama_diskon }}">
                                </div>

                                <label for="besar_diskon">Discount amount</label>
                                <div class="form-group">
                                    <input type="text" id="besar_diskon" class="form-control"
                                        placeholder="Discount amount..." name="besar_diskon"
                                        value="{{ $diskon->besar_diskon }}">
                                </div>

                                <label for="tanggal_mulai">Start date</label>
                                <div class="form-group">
                                    <input type="date" id="tanggal_mulai" class="form-control" name="tanggal_mulai"
                                        placeholder="Start date..." value="{{ $diskon->tanggal_mulai }}">
                                </div>

                                <label for="tanggal_berakhir">End date</label>
                                <div class="form-group">
                                    <input type="date" id="tanggal_berakhir" class="form-control"
                                        name="tanggal_berakhir" placeholder="End date..."
                                        value="{{ $diskon->tanggal_berakhir }}">
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

            <div class="modal fade" id="deleteModal{{ $diskon->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $diskon->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Delete discount
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Are you sure you want to delete this Discount?
                            </p>
                            <p>
                                Discount name : {{ $diskon->nama_diskon }}
                            </p>
                            <p>
                                Discount amount : {{ $diskon->besar_diskon }}%
                            </p>
                            <p>
                                Start date : {{ $diskon->tanggal_mulai }}
                            </p>
                            <p>
                                End date : {{ $diskon->tanggal_berakhir }}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>

                            <form action="{{ route($role . '.diskon.destroy', $diskon->id) }}" method="POST">
                                @csrf
                                <input type="text" value="diskon" name="role" hidden>
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
