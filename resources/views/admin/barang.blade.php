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
                <h5>Data Barang</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data
                </button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tr>
                    <td>1</td>
                    <td>Joni</td>
                    <td>Jenis A</td>
                    <td>Rp 50.000</td>
                    <td>Meter</td>
                    <td>
                        <a target="_blank"
                            href="https://storage.googleapis.com/finansialku_media/wordpress_media/2020/01/50a970a6-7-contoh-surat-pengantar-untuk-berbagai-keperluan-05-surat-pengantar-laporan-finansialku.jpg">
                            <img src="https://storage.googleapis.com/finansialku_media/wordpress_media/2020/01/50a970a6-7-contoh-surat-pengantar-untuk-berbagai-keperluan-05-surat-pengantar-laporan-finansialku.jpg"
                                style="width: 75px; height: 100px; object-fit: cover" />
                        </a>


                    </td>

                    <td style="width: 150px">
                        <button type="button" class="btn btn-success btn-sm" id="editData">Ubah</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" onsubmit="return save()">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Barang</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" required class="form-control" id="satuan" name="satuan">
                                </div>

                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Jenis Barang</label>
                                    <div class="d-flex">
                                        <select class="form-select me-2" aria-label="Default select example" id="selectStatus"
                                            name="status">
                                            <option selected value="null">Jenis Barang</option>
                                            <option value="11">Jenis A</option>
                                            <option value="11">Jenis B</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" required class="form-control" id="harga" name="harga">
                                </div>
                                
                                <div class="mt-3 mb-2">
                                    <label for="foto" class="form-label">Foto Produk</label>
                                    <input class="form-control" type="file" id="foto" name="foto_produk">
                                    <div id="showFoto"></div>
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
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
