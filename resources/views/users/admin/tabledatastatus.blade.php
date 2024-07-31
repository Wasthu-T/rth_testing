<table class="table">
    <thead>
        <tr>
            <th scope="col">Nik</th>
            <th scope="col">Alamat</th>
            <th scope="col">Lintang</th>
            <th scope="col">Bujur</th>
            <th scope="col">Alasan</th>
            <th scope="col">Tgl Buat</th>
            <th scope="col">Terakhir Ubah</th>
            <th scope="col">Status</th>
            <th scope="col">Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <div id="searchResults">
            @foreach($datas as $data)
            <tr>
                <td>{{ $data->nik }}</td>
                <td>{{ $data->loc_phntts }}</td>
                <td>{{ number_format($data->lat,4) }}</td>
                <td>{{ number_format($data->long,4) }}</td>
                <td class="text-truncate" style="max-width: 150px;">{{ $data->alasan }}</td>
                <td class="text-nowrap">{{ $data->created_at->format('d/m/Y')}}</td>
                <td class="text-nowrap">{{ $data->updated_at->format('d/m/Y')}}</td>
                @if($data->status == 0)
                <td class="text-danger">Data kurang lengkap/salah</td>
                @elseif($data->status == 1)
                <td class="text-danger">Menunggu diproses</td>
                @elseif($data->status == 2)
                <td class="text-primary">Sedang ditinjau</td>
                @elseif($data->status == 3)
                <td class="text-primary">Menunggu surat rekomendasi</td>
                @elseif($data->status == 4.1 || $data->status == 4.2 || $data->status == 4.3)
                <td class="text-primary">Sedang dilaksanakan</td>
                @elseif($data->status == 5)
                <td class="text-success">Selesai</td>
                @elseif($data->status == 6)
                <td class="text-primary">Status jalan {{$data->istansi}}</td>
                @else
                <td class="text-danger">Error silahkan menghubungi admin</td>
                @endif
                <td class="justify-content-evenly">
                    @if(Request::path() == "dashboard/admin/arsip")
                    <span class="mx-3 my-2">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#confirmPulihkanModal" data-slug="{{ $data->slug }}">
                            <i class="bi bi-box-arrow-up-right"></i>Pulihkan
                        </button>
                    </span>
                    @else
                    <a href="/dashboard/admin/{{ $data->slug }}" class="mx-3 my-2">
                        <button type="button" class="btn btn-outline-success"><i class="bi bi-box-arrow-in-down-left"></i>Tinjau</button>
                    </a>

                    @if((auth()->user()->akses_lvl == "2") && ($data->status == 0 || $data->status == 1) )
                    <span class="mx-3 my-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-slug="{{ $data->slug }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </span>
                    @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </div>

    </tbody>
</table>

@if(Request::path() == "dashboard/admin")
<!-- Modal -->
<div class="modal fade mt-5" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data dengan kode <span id="deleteSlug"></span> ini?
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
@endif

@if(Request::path() == "dashboard/admin/arsip")
<!-- Modal Konfirmasi Pemulihan -->
<div class="modal fade mt-5" id="confirmPulihkanModal" tabindex="-1" aria-labelledby="confirmPulihkanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmPulihkanModalLabel">Konfirmasi Pemulihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin memulihkan data dengan kode <span id="pulihkanSlug"></span> ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="pulihkanForm" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-success">Pulihkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@if($datas->count() === 0)
<h5 class="text-danger">Data tidak ditemukan</h5>
@endif
{!! $datas->links() !!}

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Tombol yang memicu modal
            var slug = button.getAttribute('data-slug'); // Ambil slug dari tombol
            var deleteForm = document.getElementById('deleteForm');
            var deleteSlug = document.getElementById('deleteSlug'); // Elemen untuk menampilkan slug
            deleteForm.action = "/dashboard/admin/arsip/" + slug;
            deleteSlug.textContent = slug; // Set slug ke elemen
        });

        var confirmPulihkanModal = document.getElementById('confirmPulihkanModal');
        confirmPulihkanModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Tombol yang memicu modal
            var slug = button.getAttribute('data-slug'); // Ambil slug dari tombol
            var pulihkanForm = document.getElementById('pulihkanForm');
            var pulihkanSlug = document.getElementById('pulihkanSlug'); // Elemen untuk menampilkan slug
            pulihkanForm.action = "/dashboard/admin/pulihkan/" + slug;
            pulihkanSlug.textContent = slug; // Set slug ke elemen
        });
    });
</script>
@endsection