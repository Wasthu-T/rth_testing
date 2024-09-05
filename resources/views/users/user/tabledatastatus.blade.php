<div class="row gap-5 mx-3">
    @foreach($datas as $klhn)
    <div class="card col-12 col-md-4 col-lg-3 mx-auto mx-lg-3">
        @if($klhn->ftphn)
        <div class="" style="height: 150px; overflow:hidden;">
            @php
            $filePath = asset('/' . $klhn->ftphn->ftphn);
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
            @endphp
            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp']))
            <img src="{{ $filePath }}" class="card-img-top" alt="...">
            @elseif($fileExtension === 'pdf')
            <table style="height: 150px; width:100%;">
                <tbody>
                    <tr>
                        <td class="align-middle text-center">
                            <h5>Gambar Preview Tidak Tersedia</h5>
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif
        </div>
        @else
        <table style="height: 150px;">
            <tbody>
                <tr>
                    <td class="align-middle text-center">
                        <h5>Gambar Preview Tidak Tersedia</h5>
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
        <hr>
        <div class="card-body">
            <h6>Kode :</h6>
            <h6 class="card-title">{{ $klhn->slug }}</h6>
            <div class="card-text"> Status :
                @if($klhn->status == 0)
                <p class="text-danger">Data kurang lengkap/salah</p>
                @elseif($klhn->status == 1)
                <p class="text-danger">Menunggu diproses</p>
                @elseif($klhn->status == 2)
                <p class="text-primary">Sedang ditinjau</p>
                @elseif($klhn->status == 3)
                <p class="text-primary">Menunggu surat rekomendasi</p>
                @elseif($klhn->status == 4.1 || $klhn->status == 4.2 || $klhn->status == 4.3)
                <p class="text-primary">Sedang dilaksanakan</p>
                @elseif($klhn->status == 5)
                <p class="text-success">Selesai</p>
                @elseif($klhn->status == 6)
                <p class="text-primary">Status Jalan {{$klhn->istansi}}</p>
                <p class="text-danger">Tidak dapat dilanjuti dikarenakan jalan {{$klhn->istansi}}</p>
                @else
                <p class="text-danger">Error silahkan menghubungi admin</p>
                @endif
            </div>
            <p class="card-text">Alamat : </br>{{ $klhn->loc_phntts }}</p>
        </div>
        <div class="card-text">
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-truncate">Deskripsi : </br>{{ $klhn->alasan }}</li>
                <li class="list-group-item text-truncate">Dibuat : </br>{{ $klhn->created_at->format('d/m/Y') }}</li>
            </ul>
            <div class="gap-3 pb-3">
                <a href="/dashboard/{{ $klhn->slug }}" class="btn btn-success ">Detail</a>
                @if($klhn->status == 1 || $klhn->status == 0)
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-slug="{{ $klhn->slug }}">
                    <i class="bi bi-trash"></i> Hapus
                </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- Modal -->
<div class="modal fade mt-5" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                <form id="deleteForm" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="my-3">
    {{ $datas->links() }}
</div>
@if($datas->count() === 0)
<h6 class="text-danger">Data tidak ditemukan</h6>
@endif

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Tombol yang memicu modal
            var slug = button.getAttribute('data-slug'); // Ambil slug dari tombol
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.action = "/dashboard/arsip/" + slug;
        });
    });
</script>
@endsection