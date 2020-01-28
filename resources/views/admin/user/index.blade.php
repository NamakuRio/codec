@extends('templates.master')

@section('title', 'Pengguna')

@section('css')
        <!-- Custom box css -->
        <link href="@asset('assets/libs/custombox/custombox.min.css')" rel="stylesheet" type="text/css" />

        <!-- third party css -->
        <link href="@asset('assets/libs/datatables/datatables.min.css')" rel="stylesheet" type="text/css" />
        <!-- third party css end -->
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="@route('admin.dashboard')">Admin</a></li>
                            <li class="breadcrumb-item active">Pengguna</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pengguna</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-primary">
                                <i class="fe-users font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $countAllUser }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Pengguna</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-total-users-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-warning">
                                <i class="fe-clock font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $countInactiveUser }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Belum Aktif</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-users-inactive-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-success">
                                <i class="fe-check-circle font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $countActiveUser }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Sudah Aktif</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-users-active-->
            </div> <!-- end col-->

            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-danger">
                                <i class="fe-alert-circle font-22 avatar-title text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $countBlockedUser }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Diblokir</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-users-blocked-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <a href="javascript:void(0);" class="btn btn-sm btn-blue waves-effect waves-light float-right" onclick="openModal('#modal-edit-user')">
                        <i class="mdi mdi-plus-circle"></i> Tambah Pengguna
                    </a>
                    <h4 class="header-title mb-4">Kelola Pengguna</h4>

                    <table class="table table-hover m-0 table-centered nowrap w-100" id="users-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Status</th>
                                <th>Verifikasi Email</th>
                                <th>Verifikasi No HP</th>
                                <th class="hidden-sm">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

    <!-- Modal Edit -->
    <div id="modal-edit-user" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Edit Category Name</h4>
        <div class="custom-modal-text text-left">
            <form method="POST" action="javascript:void(0)" id="form-update-category">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="edit-category-id" required>
                <div class="form-group">
                    <label for="edit-category-name">Category Name</label>
                    <input type="text" class="form-control" name="name" id="edit-category-name" placeholder="Enter category name">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light" id="btn-save-update-category">Save</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
        <!-- Modal-Effect -->
        <script src="@asset('assets/libs/custombox/custombox.min.js')"></script>

        <!-- third party js -->
        <script src="@asset('assets/libs/datatables/datatables.min.js')"></script>

        <!-- Tickets js -->
        <script src="@asset('assets/js/pages/tickets.js')"></script>
@endsection

@section('script-bottom')
    <script>
        $(function () {
            "use strict";

            getUsers();
        });

        function getUsers()
        {
            $("#users-table").dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "@route('admin.users.getUsers')",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                destroy: true,
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'username' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'status' },
                    { data: 'activation' },
                    { data: 'phone_verification' },
                    { data: 'action' },
                ],
                scrollX: true,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                columnDefs: [
                    {
                        className: "table-user",
                        targets: [
                            1
                        ],
                    },
                    {
                        className: "text-center",
                        targets: [
                            6,7
                        ],
                    }
                ]
            });
        }
    </script>
@endsection
