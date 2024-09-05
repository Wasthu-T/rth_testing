<table class="table">
    <thead>
        <tr>
            <th>kd_ruas</th>
            <th>Lintang</th>
            <th>Bujur</th>
            <th>Lokasi</th>
            <th>Keterangan</th>
            <th>Pelaporan</th>
            <th>Survei</th>
            <th>Selesai</th>
            <th>Rekomendasi</th>
            <th>Pelaksana</th>
            <th>Pelaksanaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data1 as $item)
        <tr>
            <td>{{ $item->slug }}</td>
            <td>{{ number_format($item->lat,4) }}</td>
            <td>{{ number_format($item->long,4) }}</td>
            <td>{{ $item->loc_phnpt }}</td>
            <td>{{ $item->alasan }}</td>
            <td class="text-nowrap">{{ $item->created_at->format('d/m/Y')}}</td>
            <td class="text-nowrap">{{ date("d/m/Y",strtotime($item->tgl_survei))}}</td>
            <td class="text-nowrap">{{ $item->updated_at->format('d/m/Y')}}</td>
            <td>{{ $item->survei }}</td>
            <td>{{ $item->istansi }}</td>
            @if($item->tgl_pelaksanaan)
            <td>{{ date("d/m/Y",strtotime($item->tgl_pelaksanaan)) }}</td>
            @else
            <td>Belum Melapor</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
{!! $data1->links() !!}