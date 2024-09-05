@if (auth()->user()->email_verified_at == null)
<li class="list-item">
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "email/verify" ? 'active' : ''}} {{request() -> path() === "dashboard/profil/ubah" ? 'active' : ''}}" href="/dashboard/profil">
        Verifikasi
    </a>
</li>
@else
<li class="list-item">
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "dashboard/profil" ? 'active' : ''}} {{request() -> path() === "dashboard/profil/ubah" ? 'active' : ''}}" href="/dashboard/profil">
        Profil
    </a>
</li>

<li class="list-item">
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "dashboard" ? 'active' : ''}}" href="/dashboard">
        Daftar Permohonan
    </a>
</li>

<li class="list-item">
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 {{request() -> path() === "dashboard/permohonan" ? 'active' : ''}}" aria-current="page" href="/dashboard/permohonan">
        Permohonan
    </a>
</li>
<li class="nav-item {{ request()->is('dashboard/bantuan*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3" href="/dashboard/bantuan/membuatlaporan">
        Bantuan
    </a>
    @if(request()->is('dashboard/bantuan*'))
    <ul class="flex-column ms-3" style="list-style-type: none;">
        <li class="nav-item">
            <a class="nav-link {{ request()->path() === 'dashboard/bantuan/membuatlaporan' ? 'active' : '' }}" href="/dashboard/bantuan/membuatlaporan">
                Membuat Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->path() === 'dashboard/bantuan/memperbaikikesalahanlaporan' ? 'active' : '' }}" href="/dashboard/bantuan/memperbaikikesalahanlaporan">
                Memperbaiki Kesalahan Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->path() === 'dashboard/bantuan/pelaksanaanmasyarakat' ? 'active' : '' }}" href="/dashboard/bantuan/pelaksanaanmasyarakat">
                Pelaksanaan Masyarakat
            </a>
        </li>
    </ul>
    @endif
</li>
@endif