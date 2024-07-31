<li class="list-item">
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "dashboard/admin" ? 'active' : ''}}  aria-current=" page" href="/dashboard/admin">
        Status permohonan
    </a>
    @if(auth()->user()->akses_lvl == "2")
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "dashboard/admin/arsip" ? 'active' : ''}}  aria-current=" page" href="/dashboard/admin/arsip">
        Arsip
    </a>
    @endif
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "dashboard/admin/rekapitulasi" ? 'active' : ''}}  aria-current=" page" href="/dashboard/admin/rekapitulasi">
        Rekapitulasi RTH
    </a>
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "dashboard/admin/petarekapitulasi" ? 'active' : ''}}  aria-current=" page" href="/dashboard/admin/petarekapitulasi">
        Peta Rekapitulasi RTH
    </a>
</li>
<li class="nav-item {{ request()->is('dashboard/admin/bantuan*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3" href="/dashboard/admin/bantuan/filter">
        Bantuan
    </a>
    @if(request()->is('dashboard/admin/bantuan*'))
    <ul class="flex-column ms-3" style="list-style-type: none;">
        <li class="nav-item">
            <a class="nav-link {{ request()->path() === 'dashboard/admin/bantuan/filter' ? 'active' : '' }}" href="/dashboard/admin/bantuan/filter">
                Filter
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->path() === 'dashboard/admin/bantuan/tampilanrekapitulasi' ? 'active' : '' }}" href="/dashboard/admin/bantuan/tampilanrekapitulasi">
                Tampilan Rekapitulasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->path() === 'dashboard/admin/bantuan/prosespermohonan' ? 'active' : '' }}" href="/dashboard/admin/bantuan/prosespermohonan">
                Proses Permohonan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->path() === 'dashboard/admin/bantuan/hapuspermohonan' ? 'active' : '' }}" href="/dashboard/admin/bantuan/hapuspermohonan">
                Hapus Permohonan
            </a>
        </li>
    </ul>
    @endif
</li>