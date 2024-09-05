<?php

namespace App\Http\Controllers;

use App\Models\klhn;
use App\Models\ftphn;
use App\Models\backup;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request, klhn $klhn, ftphn $ftphn)
    {
        $routeName = $request->path();
        switch ($routeName) {
            case 'dashboard/admin/bantuan/filter':
                return view('users.admin.bantuan');
            case 'dashboard/admin/arsip':
                $query = $request->input('query');
                $status = $request->input('status');
                $orderBy = $request->input('order_by', 'status');
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $klhnQuery = klhn::query();

                if ($query) {
                    $klhnQuery->where(function ($q) use ($query) {
                        $q->where('nik', 'like', $query . '%')
                            ->orWhere('slug', 'like', $query . '%');
                    });
                }

                if ($status !== null) {
                    if ($status == '0') {
                        $klhnQuery->where('status', '0');
                    } else if ($status == '4.1') {
                        $klhnQuery->whereIn('status', ['4.1', '4.2']);
                    } else {
                        $klhnQuery->where('status', $status);
                    }
                }

                if ($startDate) {
                    $klhnQuery->whereDate('created_at', '>=', $startDate);
                }

                if ($endDate) {
                    $klhnQuery->whereDate('created_at', '<=', $endDate);
                }

                if ($orderBy === 'asc') {
                    $klhnQuery->orderBy('updated_at', 'asc');
                } elseif ($orderBy === 'dsc') {
                    $klhnQuery->orderBy('updated_at', 'desc');
                } else {
                    $klhnQuery->orderBy('created_at', 'desc');
                }

                if ((auth()->user()->akses_lvl == 1) && ($status === null || $status !== null)) {
                    $klhnQuery->whereIn('status', ['4.2', '4.3', '5']);
                }

                $klhnQuery->join('backups', 'klhns.slug', '=', 'backups.kd_hapus');
                $datas = $klhnQuery->paginate(10);
                $backUrl = '/dashboard/admin';

                if ($request->ajax()) {
                    return view('users.admin.tabledatastatus', compact('datas'))->render();
                }

                return view('users.admin.backup', [
                    "datas" => $datas,
                    "backUrl" => $backUrl,
                    "filter" => [$query, $status, $startDate, $endDate, $orderBy]
                ]);

            case 'dashboard/admin/bantuan/tampilanrekapitulasi':
                return view('users.admin.bantuan');
            case 'dashboard/admin/bantuan/hapuspermohonan':
                return view('users.admin.bantuan');
            case 'dashboard/admin/bantuan/prosespermohonan':
                return view('users.admin.bantuan');
            case 'dashboard/admin/petarekapitulasi':
                return view('users.admin.petarekap');
            case 'dashboard/admin/rekapitulasi':
                $data1 = Klhn::whereIn('status', ["5"])
                    ->paginate(10);
                if ($request->ajax()) {
                    return view('users.admin.tabledata', compact('data1'))->render();
                }
                return view('users.admin.rekapitulasi', compact('data1'));
            case 'dashboard/admin':
                $query = $request->input('query');
                $status = $request->input('status');
                $orderBy = $request->input('order_by', 'status');
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $klhnQuery = klhn::query();

                if ($query) {
                    $klhnQuery->where(function ($q) use ($query) {
                        $q->where('nik', 'like', $query . '%')
                            ->orWhere('slug', 'like', $query . '%');
                    });
                }

                if ($status !== null) {
                    if ($status == '0') {
                        $klhnQuery->where('status', '0');
                    } else if ($status == '4.1') {
                        $klhnQuery->whereIn('status', ['4.1', '4.2']);
                    } else if ($status == '4.2') {
                        $klhnQuery->whereIn('status', ['4.2', '4.3']);
                    } else {
                        $klhnQuery->where('status', $status);
                    }
                }

                if ($startDate) {
                    $klhnQuery->whereDate('created_at', '>=', $startDate);
                }

                if ($endDate) {
                    $klhnQuery->whereDate('created_at', '<=', $endDate);
                }

                if ($orderBy === 'asc') {
                    $klhnQuery->orderBy('updated_at', 'asc');
                } elseif ($orderBy === 'dsc') {
                    $klhnQuery->orderBy('updated_at', 'desc');
                } else {
                    $klhnQuery->orderBy('created_at', 'desc');
                }




                if ((auth()->user()->akses_lvl == 1) && ($status === null || $status !== null)) {
                    $klhnQuery->whereIn('status', ['4.2', '4.3', '5']);
                }
                // Menambahkan join dengan backup (left join) untuk memastikan data yang ada di klhn tetap terambil
                $klhnQuery->leftJoin('backups', 'klhns.slug', '=', 'backups.kd_hapus')
                    ->whereNull('backups.id'); // Hanya mengambil data yang tidak ada di backup
                $datas = $klhnQuery->paginate(10);
                $backUrl = '/dashboard/admin';

                if ($request->ajax()) {
                    return view('users.admin.tabledatastatus', compact('datas'))->render();
                }

                return view('users.admin.main', [
                    "datas" => $datas,
                    "backUrl" => $backUrl,
                    "filter" => [$query, $status, $startDate, $endDate, $orderBy]
                ]);
            default:
                return redirect('dashboard/admin/bantuan/filter');
        }
    }
    public function show(Request $request, klhn $klhn)
    {
        $existsInBackup = backup::where('kd_hapus', $klhn->slug)->exists();
        if ($existsInBackup) {
            return redirect('/dashboard/admin');
        }
        if (!in_array($klhn->status, ["4.2", "4.3","5"]) && auth()->user()->akses_lvl == 1) {
            return redirect('/dashboard/admin');
        }
        $foto = $klhn->fotos;
        $backUrl = '/dashboard/admin';
        $datauser = $klhn->datauser;
        $fotoktp = '';
        $surat = [];
        $svr = [];
        $plk = [];
        $lm = [];
        $user = auth()->user();
        if ($user->admin == "1") {
            $srtrths = $klhn->surats;

            $fotoktp = $klhn->ftktp;
            $lms = $klhn->lmrecs;
            $svrs = $klhn->surveis;
            $plks = $klhn->plksns;

            foreach ($srtrths as $srtrth) {
                $surat[] = $srtrth->srtrth;
            }
            foreach ($lms as $l) {
                $lm[] = $l->lmrec;
            }
            foreach ($svrs as $s) {
                $svr[] = $s->ftphn;
            }
            foreach ($plks as $p) {
                $plk[] = $p->ftplksn;
            }
        }
        $nextUrl = $request->path() . "/update";
        return view('users.admin.tinjau', [
            'data' => $klhn,
            'datauser' => $datauser,
            'fotos' => $foto,
            'fotoktp' => $fotoktp,
            'lms' => $lm,
            'suratrth' => $surat,
            'surveis' => $svr,
            'pelaksanas' => $plk,
            'backUrl' => $backUrl,
            'nextUrl' => $nextUrl
        ]);
    }

    public function update(Request $request, klhn $klhn)
    {
        $back = $request->path();
        $backUrl = str_replace('/update', '', $back);
        if (!in_array($klhn->status, ["4.2", "4.3","5"]) && auth()->user()->akses_lvl == 1) {
            return redirect('/dashboard/admin');
        }

        if (in_array($klhn->status, ["4.2", "4.3"]) && auth()->user()->akses_lvl == 2) {
            return redirect('/dashboard/admin');
        }

        return view('users.admin.uprth', [
            'data' => $klhn,
            'backUrl' => $backUrl

        ]);
    }
    public function getdata(Request $request)
    {
        // Mendapatkan parameter 'no_ruas' dari query string
        $noRuas = $request->query('no_ruas');

        // Membangun query
        // $query = Klhn::whereIn('status', ['5']);

        // Menambahkan kondisi filter jika 'no_ruas' ada
        if ($noRuas) {
            $query = Klhn::where('no_ruas', $noRuas);
        }

        
        $data2 = $query->paginate(10);
        if ($data2->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data2);
    }
    public function pulihkan(backup $backup)
    {
        $kd = $backup->kd_hapus;
        backup::where('kd_hapus', $kd)->delete();
        return redirect('/dashboard/admin/arsip')->with('berhasil', 'Data berhasil dipulihkan');
    }
    
}
