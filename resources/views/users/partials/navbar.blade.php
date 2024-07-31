<header class="navbar sticky-top bg-success flex-md-nowrap p-0 shadow ">
    @if (auth()->user()->admin == 0)
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">{{ auth()->user()->username }}</a>
    @else
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">{{ auth()->user()->nm_lengkap }}</a>
    @endif

    <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
        </li>
    </ul>
</header>


<div class="container-fluid ">
    <div class="row ">
        <div class="nav nav-underline text-white border-right col-md-3 col-lg-2 bg-success sidebar-bg">
            <div class=" offcanvas-md offcanvas-end bg-success " tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ auth()->user()->nm_dpn }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body text-white d-md-flex flex-column p-0 mt-5 ">
                    <ul class="list-group">
                        @if (auth()->user()->admin == 0)
                        @include('users.partials.user')
                        @else
                        @include('users.partials.admin')
                        @endif
                    </ul>



                    <hr class="my-3">

                    <ul class="list-group flex-column mb-auto">
                        <li class="list-item">
                            <a class="nav-link d-flex align-items-center gap-2 mx-3 px-3 w-75" aria-current="page" href="/beranda">
                                Beranda
                            </a>
                        </li>
                        <li class="list-item">
                            <form action="/keluar" method="post">
                                @csrf
                                <button type="submit" class="nav-link d-flex align-items-center gap-2 mx-3 px-3 w-75">
                                    Keluar
                                </button>
                            </form>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>