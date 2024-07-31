<?php

namespace App\Http\Controllers;

use App\Models\klhn;
use App\Models\User;
use App\Models\ftphn;
use App\Models\backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request, klhn $klhn, ftphn $ftphn)
    {
        $routeName = $request->path();
        switch ($routeName) {

            case 'email/verify':
                $user = auth()->user();
                if($user->email_verified_at != null){
                    return redirect('dashboard/profil');
                }else{
                    return view('users.user.profil');
                }
            case 'dashboard/bantuan/membuatlaporan':
                return view('users.user.bantuan');
            case 'dashboard/bantuan/memperbaikikesalahanlaporan':
                return view('users.user.bantuan');
            case 'dashboard/bantuan/pelaksanaanmasyarakat':
                return view('users.user.bantuan');
            case 'dashboard/profil':
                return view('users.user.profil');
            case 'dashboard/profil/ubah':
                return view('users.user.ubah');
            case 'dashboard/profil/ubahpassword':
                return view('users.user.ubahpass');
            case 'dashboard':
                $user = auth()->user();
                $query = $request->input('query');
                $status = $request->input('status');
                $orderBy = $request->input('order_by', 'status');
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $klhnQuery = $klhn->where('uuid', $user->uuid);
                $initialQueryCount = count($klhnQuery->getQuery()->wheres);

                if ($query) {
                    $klhnQuery->where('slug', 'like', $query . '%');
                }

                if ($status) {
                    $klhnQuery->where('status', $status);
                } else if ($status == '0') {
                    $klhnQuery->where('status', '0');
                } else if ($status == '4.1') {
                    $klhnQuery->whereIn('status', ['4.1', '4.2']);
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
                }

                $finalQueryCount = count($klhnQuery->getQuery()->wheres);
                if ($initialQueryCount == $finalQueryCount) {
                    $klhnQuery->orderBy('created_at', 'desc');
                }

                // Menambahkan join dengan backup (left join) untuk memastikan data yang ada di klhn tetap terambil
                $klhnQuery->leftJoin('backups', 'klhns.slug', '=', 'backups.kd_hapus')
                    ->whereNull('backups.id'); // Hanya mengambil data yang tidak ada di backup
                $datas = $klhnQuery->paginate(9);
                $backUrl = '/dashboard';

                if ($request->ajax()) {
                    return view('users.user.tabledatastatus', compact('datas'))->render();
                }
                return view('users.user.main', [
                    "datas" => $datas,
                    "backUrl" => $backUrl,
                    "filter" => [$query, $status, $startDate, $endDate, $orderBy]
                ]);
            default:
                return redirect('/dashboard/bantuan');
        }
    }



    public function show(Klhn $klhn)
    {
        $existsInBackup = backup::where('kd_hapus', $klhn->slug)->exists();
        if ($existsInBackup) {
            return redirect('/dashboard');
        }
        if ($klhn->uuid == auth()->user()->uuid) {
            $slug = $klhn->slug;
            $foto = $klhn->fotos;
            $backUrl = '/dashboard';
            $editUrl = '/dashboard/' . $slug . '/edit';
            $surats = $klhn->surats;
            $lmrecs = $klhn->lmrecs;
            $ftsurs = $klhn->surveis;
            $plks = $klhn->plksns;


            return view('users.user.show', [
                'data' => $klhn,
                'surats' => $surats,
                'lmrecs' => $lmrecs,
                'surveis' => $ftsurs,
                'pelaksanas' => $plks,
                'fotos' => $foto,
                'backUrl' => $backUrl,
                'editUrl' => $editUrl
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function updateuser(Request $request, User $user)
    {
        $email = auth()->user()->email;
        $rules = [
            'nm_lengkap' => 'required|max:255',
            'alamat' => 'required',
            'no_hp' => 'required|numeric',
            'email' => 'required|email:dns'
        ];

        if ($request->email == $email) {
            unset($rules['email']);
        }


        $validated = $request->validate($rules);
        $uuid = auth()->user()->uuid;
        $userdata = User::where('uuid', $uuid)->first();
        if ($userdata) {
            $userdata->update($validated);
        } else {
            // Handle jika user tidak ditemukan
            return redirect('/dashboard/profil')->with('gagal', 'Data gagal diubah mohon hubungi admin');
        }

        return redirect('/dashboard/profil')->with('berhasil', 'Data berhasil diubah');
    }
    public function updatepass(Request $request)
    {
        $request->validate([
            'current_password' => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);
        $user = auth()->user();
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah']);
            }

            $dataToUpdate['password'] = Hash::make($request->new_password);
        }

        $uuid = $user->uuid;
        $userdata = User::where('uuid', $uuid)->first();
        if ($userdata) {
            $userdata->update($dataToUpdate);
        } else {
            return redirect('/dashboard/profil')->with('gagal', 'Data gagal diubah mohon hubungi admin');
        }

        return redirect('/dashboard/profil')->with('berhasil', 'Password berhasil diubah');
    }

}
