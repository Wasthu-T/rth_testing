@extends('users.layout.main')

@section('container-user')

@if(request()->is('dashboard/admin/bantuan/filter'))
@include('users.admin.bantuan.rth1')

@elseif(request()->is('dashboard/admin/bantuan/tampilanrekapitulasi'))
@include('users.admin.bantuan.rth2')

@elseif(request()->is('dashboard/admin/bantuan/hapuspermohonan'))
@include('users.admin.bantuan.rth5')

@elseif(request()->is('dashboard/admin/bantuan/prosespermohonan'))
@if (auth()->user()->akses_lvl == 2)
@include('users.admin.bantuan.rth3')
@else()
@include('users.admin.bantuan.rth4')
@endif

@endif

</div>
</div>
</div>

@endsection

@section('scripts')

@endsection