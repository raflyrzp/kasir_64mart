@extends('layout/main');

@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title no-print">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>App Identity</h3>
                    <p class="text-subtitle text-muted">
                        Manage Application Identity here.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href='/{{ $role }}'>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                App Identity
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

        <section id="multiple-column-form no-print">
            <div class="row match-height">
                <div class="col-12 no-print">
                    <div class="card">
                        <div class="card-header pb-0 no-print">
                            <h4 class="card-title">Edit Identity</h4>
                        </div>
                        <div class="card-content no-print">
                            <div class="card-body">
                                <form class="form" action="{{ route($role . '.identitas.update', $identitas->id) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="nama_app">Name App</label>
                                                <input type="text" id="nama_app" class="form-control" name="nama_app"
                                                    value="{{ $identitas->nama_app }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="alamat" class="form-label">Address</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $identitas->alamat }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="logo" class="form-label">Logo</label>
                                                <input class="form-control" type="file" id="logo" name="logo">
                                            </div>

                                            <div class="mb-3">
                                                <label for="background_login" class="form-label">Login Background</label>
                                                <input class="form-control" type="file" id="background_login"
                                                    name="background_login">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
