<nav class="navbar navbar-expand-lg bg-success">
  <div class="container">
    <a class="navbar-brand" href="/beranda">
      <img src="/img/logo/logodlh-bglight1.png" alt="logo_bantul" width="40px" height="auto">
      <p class="logo d-inline fs-6">Simpel RTH </p>
    </a>
    <button id="btn-colapse" class="navbar-toggler colbtn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-underline">
        <li class="nav-item">
          <a class="nav-link {{request() -> segment(1) === "beranda" ? 'active' : ''}}" aria-current="page" href="/beranda">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{request() -> segment(1) === "profil" ? 'active' : ''}}" href="/profil">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{request() -> segment(1) === "kontak" ? 'active' : ''}}" href="/kontak">Kontak</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{request() -> segment(1) === "bantuan" ? 'active' : ''}}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Bantuan
          </a>
          <ul class="dropdown-menu ">
            <li><a class="dropdown-item " href="/bantuan/daftar">Daftar</a></li>
            <li><a class="dropdown-item " href="/bantuan/pelaporan">Pelaporan</a></li>
          </ul>
        </li>
      </ul>

      <ul class="navbar-nav nav-underline">

        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fs-6" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          @if (auth()->user()->admin == 0 )
          Selamat Datang {{auth()->user()->username}}
          @else 
          {{auth()->user()->username}}
          @endif
          </a>
          <ul class="dropdown-menu ">
            @if (auth()->user()->admin == 0 )
            <li><a class="dropdown-item {{request() -> segment(1) === "/dashboard/profil" ? 'active' : ''}}" href="/dashboard/profil"><i class="bi bi-person"></i>Profil</a></li>
            @else
            <li><a class="dropdown-item {{request() -> segment(1) === "/dashboard" ? 'active' : ''}}" href="/dashboard/admin"><i class="bi bi-layout-text-window-reverse"></i>Dashboard</a></li>
            @endif
            <li>
              <form action="/keluar" method="post">
                @csrf
                <button type="Submit" class="btn dropdown-item">
                  <a><i class="bi bi-box-arrow-right"></i>Keluar</a>
                </button>
              </form>
            </li>

          </ul>
        </li>
        @else

        <li class="nav-item">
          <a class="nav-link {{request() -> segment(1) === "masuk" ? 'active' : ''}}" aria-current="page" href="/masuk">
            <i class="bi bi-box-arrow-in-right"></i>Masuk
          </a>
        </li>
        @endauth
      </ul>



    </div>
  </div>
</nav>