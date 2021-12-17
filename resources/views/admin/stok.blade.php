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


            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Data Stock Barang</h5>
                {{-- <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data
                </button> --}}
                <div class="ms-auto">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Cabang </label>
                        <div class="d-flex">
                            <form id="formCari" action="/admin/pesanan">
                                <select class="form-select" aria-label="Default select example" id="statusCari" name="status">
                                    <option selected value="">Semua</option>
                                    <option selected value="">Cabang A</option>
                                    <option selected value="">Cabang B</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Stock</th>
                        <th>Satuan</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tr>
                    <td>1</td>
                    <td>Joni</td>
                    <td>Jenis A</td>
                    <td>100</td>
                    <td>Meter</td>

                    <td style="width: 150px">
                        <button type="button" class="btn btn-success btn-sm" id="editData">Log Barang</button>
                    </td>
                </tr>


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

@section('script')
    <script>
        $(document).ready(function() {

        })

        $(document).on('click', '#editData, #addData', function() {
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
