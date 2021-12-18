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
                <h5>Data Jenis Barang</h5>
                <button type="button" class="btn btn-primary btn-sm  ms-auto" data-bs-toggle="modal"
                        data-bs-target="#tambahsiswa">Tambah Data
                </button>
            </div>
            <table class="table table-striped table-bordered ">
                <thead>
                <th>
                    #
                </th>
                <th>
                    Nama Jenis
                </th>
                <th>
                    Action
                </th>
                </thead>
                <tbody>
                @forelse($data as $v)
                    <tr>
                        <td>
                            {{ $loop->index + 1 }}
                        </td>
                        <td>
                            {{ $v->nama }}
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit"
                                    data-id="{{ $v->id }}"
                                    data-nama="{{ $v->nama }}"
                            >Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $v->id }}">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">
                            Tidak Ada Data Jenis Barang
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div>
            <div class="modal fade" id="tambahsiswa" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jenis Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Data Jenis Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="/admin/jenis/patch">
                                @csrf
                                <input type="hidden" name="id-edit" id="id-edit">
                                <div class="mb-3">
                                    <label for="nama-edit" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama-edit" name="nama-edit">
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
        $(document).ready(function () {
            $('.btn-edit').on('click', function () {
                let id = this.dataset.id;
                let nama = this.dataset.nama;
                $('#id-edit').val(id);
                $('#nama-edit').val(nama);
                $('#modal-edit').modal('show')
            });

            $('.btn-delete').on('click', function () {
                hapus(this.dataset.id);
            })
        });

        async function destroy(id) {
            try {
                let response = await $.post('/admin/jenis/delete', {
                    _token: '{{ csrf_token() }}',
                    id: id
                });
                swal("Berhasil Menghapus data!", {
                    icon: "success",
                });
                window.location.reload();
            } catch (e) {
                console.log(e);
                alert('gagal')
            }
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
                        destroy(id);
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
