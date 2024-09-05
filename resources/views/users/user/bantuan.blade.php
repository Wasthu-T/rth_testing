@extends('users.layout.main')

@section('container-user')

@if(request()->is('dashboard/bantuan/membuatlaporan'))
@include('users.user.bantuan1')

@elseif(request()->is('dashboard/bantuan/memperbaikikesalahanlaporan'))
@include('users.user.bantuan2')

@elseif(request()->is('dashboard/bantuan/pelaksanaanmasyarakat'))
@include('users.user.bantuan3')

@endif

@endsection

@section('scripts')

@endsection