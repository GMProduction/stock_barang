@extends('admin.base')

@section('title')
    Data Siswa
@endsection

@section('content')

    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", "Berhasil Menambah data!", "success");
        </script>
    @endif

    <section class="m-2">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5>Data Barang Keluar</h5>
                {{-- <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data
                </button> --}}
                <div class="ms-auto">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Cabang </label>
                        <div class="d-flex">
                            <select class="form-select" aria-label="Default select example" id="cabang"
                                    name="cabang">
                                <option value="">Semua</option>
                                @foreach($cabang as $item)
                                    <option
                                        value="{{ $item->id }}" {{ auth()->user()->cabang_id === $item->id ? 'selected' :'' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-end mb-3">
                <div class="me-2 ms-2">
                    <label for="kategori" class="form-label">Periode</label>
                    <div class="input-group input-daterange">
                        <input type="text" class="form-control me-2 txt-tgl" name="start" id="start"
                               style="background-color: white; line-height: 2.0;" readonly
                               value="{{ date('d-m-Y') }}" required>
                        <div class="input-group-addon">to</div>
                        <input type="text" class="form-control ms-2 txt-tgl" name="end" id="end"
                               style="background-color: white; line-height: 2.0;" readonly
                               value="{{ date('d-m-Y') }}" required>
                    </div>
                </div>
                <a class="btn btn-warning" id="cetak" target="_blank" href="#">Cetak</a>
            </div>
            <table class="table table-striped table-bordered w-100" id="myTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Tanggal</th>
                    <th>Qty</th>
                    <th>Keterangan</th>
                    <th>Cabang</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div>

            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Log Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Cabang</th>
                                    <th>Jenis Log</th>
                                    <th>Jumlah</th>
                                </tr>
                                </thead>

                                <tr>
                                    <td>1</td>
                                    <td>19 Nov 2021</td>
                                    <td>Cabang A</td>
                                    <td>Barang Masuk</td>
                                    <td>100</td>


                                </tr>


                            </table>
                        </div>


                    </div>
                </div>
            </div>

        </div>

    </section>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script>
        $('.input-daterange input').each(function () {
            $(this).datepicker({
                format: "dd-mm-yyyy"
            });
        });
        var table;

        function reload() {
            table.ajax.reload();
        }

        function loadTable() {
            table = $('#myTable').DataTable({
                scrollX: true,
                processing: true,
                ajax: {
                    url: '/admin/laporan-barang-keluar/list',
                    type: 'GET',
                    'data': function (d) {
                        return $.extend(
                            {},
                            d,
                            {
                                'start': $('#start').val(),
                                'end': $('#end').val(),
                                'cabang': $('#cabang').val(),
                            }
                        );
                    },
                },
                'columnDefs': [
                    {
                        "targets": 0, // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": 2, // your case first column
                        "className": "text-center",
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                    },
                    {
                        "targets": 4, // your case first column
                        "className": "text-center",
                    },
                ],
                "columns": [
                    {
                        data: null, render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {data: "barang.nama"},
                    {data: "barang.jenis.nama"},
                    {data: "tanggal"},
                    {data: "qty"},
                    {data: "keterangan"},
                    {data: "cabang.nama"},
                    // {
                    //     data: null, render: function (data, type, row, meta) {
                    //         return '<a href="#" class="btn btn-primary btn-sm text-white btn-detail" data-id="' + data['id'] + '">Log Barang</a>';
                    //     }
                    // },
                ]
            });

            table.on('draw', function () {
                console.log('redraw table')
            })
        }

        $(document).ready(function () {
            loadTable();
            $('#cabang').on('change', function () {
                reload();
            });
            $('.txt-tgl').on('change', function () {
                reload();
            });

            $('#cetak').on('click', function (e) {
                e.preventDefault();
                let start = $('#start').val();
                let end = $('#end').val();
                let cabang = $('#cabang').val();
                window.open('/admin/laporan-barang-keluar/print?start=' + start + '&end=' + end + '&cabang=' + cabang, '_blank');
            });
        });

        $(document).on('click', '#editData, #addData', function () {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #nphp').val($(this).data('hp'))
            $('#modal #alamat').val($(this).data('alamat'))
            $('#modal #no_ktp').val($(this).data('ktp'))
            $('#modal #username').val($(this).data('username'))
            $('#modal #password').val('')
            $('#modal #password-confirmation').val('')
            $('#showFoto').empty();
            if ($(this).data('id')) {
                $('#modal #password').val('**********')
                $('#modal #password-confirmation').val('**********')
            }
            if ($(this).data('foto')) {
                $('#showFoto').html('<img src="' + $(this).data('foto') + '" height="50">')
            }
            $('#modal').modal('show')
        })

        function save() {
            saveData('Simpan Data', 'form');
            return false;
        }

        function after() {

        }

        function hapus(id, name) {
            swal({
                title: "Menghapus data?",
                text: "Apa kamu yakin, ingin menghapus data ?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil Menghapus data!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
