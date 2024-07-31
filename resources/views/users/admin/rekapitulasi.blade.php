@extends('users.layout.main')

@section('container-user')
<h2 class="my-3 text-center">Rekapitulasi RTH</h2>
<div class="container my-5">
    <div class="table-responsive">
        <div id="data-container">
            @include('users.admin.tabledata', ['data1' => $data1])
        </div>
    </div>
</div>

</div>
</div>
</div>

@endsection

@section('scripts')
<script src="/js/datarekap.js"></script>

@endsection