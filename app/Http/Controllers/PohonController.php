<?php

namespace App\Http\Controllers;

use App\Models\klhn;
use App\Models\ftphn;
use App\Models\plksn;
use App\Models\backup;
use App\Models\ftsurvei;
use App\Models\suratrth;
use App\Rules\Totalsize;
use App\Models\lmrecomen;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;


class PohonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.user.permohonan');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function storejln(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|captcha',
        ]);
        $validata1 = $request->validate([
            'nik' => ['required', 'numeric', 'digits:16'],
            'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'long' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'loc_phnpt' => ['nullable'],
            'loc_phntts' => ['required'],
            'alasan' => 'required',
        ]);
        $uuid = auth()->user()->uuid;
        $jln = $request->input('jln');
        $validata1['uuid'] = $uuid;

        $locpt = $request->input('loc_phnpt');
        if ($locpt == null) {
            $validata1['no_ruas'] = 'N000';
            $noruas = 'N000';
        } else {
            $lokasi = $locpt;
            $parts = explode(',', $lokasi);
            $kd_ruas = trim($parts[0]);
            $validata1['no_ruas'] = $kd_ruas;
            $realkd_ruas = str_replace('.', '', $kd_ruas);
            $noruas = $realkd_ruas;
        }
        $currentDateTime = Carbon::now();
        $dateString = $currentDateTime->format('Ymd');
        $slugtest = $noruas . $dateString;

        $slugcheck = klhn::selectRaw("slug")
            ->where('slug', 'LIKE', $slugtest . '%')
            ->get()
            ->count();

        $num = $slugcheck + 1;
        $slugnum = str_pad($num, 3, '0', STR_PAD_LEFT);
        if ($slugcheck) {
            $validata1['slug'] = $slugtest . $slugnum;
        } else {
            $validata1['slug'] = $slugtest . $slugnum;
        }
        $validata1['status'] = "6";
        $validata1['istansi'] = $jln;
        klhn::create($validata1);
    }

    public function storerekap(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|captcha',
        ]);
        $validated = $request->validate([
            'nik' => ['required', 'numeric', 'digits:16'],
            'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'long' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'loc_phnpt' => ['nullable'],
            'loc_phntts' => ['required'],
            'alasan' => 'required',
            'ftktp' => ['mimetypes:image/*,application/pdf', 'file', 'max:2048'],
            'ftphn' => ['array', 'min:1', new Totalsize],
            'ftphn.*' => ['mimetypes:image/*,application/pdf', 'file'],
            'lmrec' => ['array', 'min:1', new Totalsize],
            'lmrec.*' => ['file', 'mimetypes:image/*,application/pdf'],
        ]);
        $validata1 = array_intersect_key($validated, array_flip([
            'nik', 'lat', 'long', 'loc_phnpt', 'loc_phntts', 'ftktp', 'alasan'
        ]));

        $validata2 = array_intersect_key($validated, array_flip([
            'ftphn.*', 'lmrec.*', 'ftphn', 'lmrec'
        ]));
        $uuid = auth()->user()->uuid;
        $validata1['uuid'] = $uuid;

        $locpt = $request->input('loc_phnpt');
        if ($locpt == null) {
            $validata1['no_ruas'] = 'N000';
            $noruas = 'N000';
        } else {
            $lokasi = $locpt;
            $parts = explode(',', $lokasi);
            $kd_ruas = trim($parts[0]);
            $validata1['no_ruas'] = $kd_ruas;
            $realkd_ruas = str_replace('.', '', $kd_ruas);
            $noruas = $realkd_ruas;
        }
        $currentDateTime = Carbon::now();
        $dateString = $currentDateTime->format('Ymd');
        $slugtest = $noruas . $dateString;

        $slugcheck = klhn::selectRaw("slug")
            ->where('slug', 'LIKE', $slugtest . '%')
            ->get()
            ->count();

        $num = $slugcheck + 1;
        $slugnum = str_pad($num, 3, '0', STR_PAD_LEFT);
        if ($slugcheck) {
            $validata1['slug'] = $slugtest . $slugnum;
        } else {
            $validata1['slug'] = $slugtest . $slugnum;
        }


        if ($request->file('ftktp')) {
            $relativePath = 'foto/' . $slugtest . $slugnum . '/ktp';
            $photo = $request->file('ftktp');
            $filePath = $photo->store($relativePath, 'public');
            $databasePath = str_replace('public/', '', $filePath);
            $validata1['ftktp'] = $databasePath;
        }
        klhn::create($validata1);
        $slug2 = $validata1['slug'];

        foreach ($request->file('ftphn') as $photo) {
            $relativePath = 'foto/' . $slugtest . $slugnum . '/rth';
            $filePath = $photo->store($relativePath, 'public');
            $databasePath = str_replace('public/', '', $filePath);
            $validata2['ftphn'] = $databasePath;
            ftphn::create([
                'slug' => $slug2,
                'ftphn' => $databasePath
            ]);
        }
        foreach ($request->file('lmrec') as $photo) {
            $relativePath = 'foto/' . $slugtest . $slugnum . '/lm';
            $filePath = $photo->store($relativePath, 'public');
            $databasePath = str_replace('public/', '', $filePath);
            $validata2['lmrec'] = $databasePath;
            lmrecomen::create([
                'slug' => $slug2,
                'lmrec' => $validata2['lmrec']
            ]);
        }
    }
    public function store(Request $request)
    {
        $stt = $request->input('stt');
        $jln = $request->input('jln');
        if ($stt == "1") {
            $this->storejln($request);
            return redirect('/dashboard')->with('status', 'berhasil menambahkan data');
        } else if($stt == "2" && $jln == null){
            $this->storerekap($request);
            return redirect('/dashboard')->with('status', 'berhasil menambahkan data rth');
        } else if($stt == "3"){
            return back()->with('gagal', 'Data tidak dapat diproses');
        } else {
            return redirect('/dashboard')->with('gagal', 'gagal menambahkan data rth');
        }
    }

    public function storeadmin(Request $request)
    {
        $validata1 = $request->validate([
            'nik' => ['numeric', 'digits:16'],
            'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'long' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'loc_phnpt' => 'nullable'
        ]);
        $slug = $request->input('slug');
        $klhndata = klhn::where('slug', $slug)->first();
        if (($klhndata->status == "0" || $klhndata->status == "1") and ($request->input('status') == "1")) {
            $validata1['status'] = "2";
            $validata1['note'] = $request->input('alasan');
            $klhndata->update($validata1);
            $mess = "Berhasil mengubah rth menjadi status tinjau";
        } elseif (($klhndata->status == "0" || $klhndata->status == "1") and ($request->input('status') == "2")) {
            $validata1['status'] = "0";
            $validata1['note'] = $request->input('alasan');
            $klhndata->update($validata1);
            $mess = "Berhasil mengubah rth menjadi status data kurang lengkap";
        } elseif ($klhndata->status == "2") {
            $validata2 = $request->validate([
                'hasil' => 'required',
                'tgl_survei' =>
                [
                    'required',
                    'date',
                    'before_or_equal:today',
                    'after_or_equal:' . $klhndata->created_at->format('Y-m-d')
                ],
                'ftsurvei' => ['array', 'min:1', 'required', new Totalsize],
                'ftsurvei.*' => ['required', 'mimetypes:image/*,application/pdf', 'file'],
            ]);
            foreach ($request->file('ftsurvei') as $photo) {
                $relativePath = 'foto/' . $slug . '/ftsurvei';
                $filePath = $photo->store($relativePath, 'public');
                $databasePath = str_replace('public/', '', $filePath);
                $ftsur['ftphn'] = $databasePath;
                $ftsur['slug'] = $slug;
                ftsurvei::create($ftsur);
            }

            $datasurvei['survei'] = $validata2['hasil'];
            $datasurvei['tgl_survei'] = $validata2['tgl_survei'];
            $datasurvei['status'] = "3";
            $klhndata->update($datasurvei);
            $mess = "Berhasil mengubah rth menjadi status rekomendasi";
        } else if ($klhndata->status == "3") {
            $validata2 = $request->validate([
                'istansi' => 'required',
                'recrth' => ['array', 'min:1', 'required', new Totalsize],
                'recrth.*' => ['required', 'mimetypes:image/*,application/pdf', 'file'],
            ]);
            foreach ($request->file('recrth') as $photo) {
                $relativePath = 'foto/' . $slug . '/recrth';
                $filePath = $photo->store($relativePath, 'public');
                $databasePath = str_replace('public/', '', $filePath);
                $ftrec['srtrth'] = $databasePath;
                $ftrec['slug'] = $slug;
                suratrth::create($ftrec);
            }

            // Istansi
            $datasurvei['istansi'] = $validata2['istansi'];
            if ($datasurvei['istansi'] == 'dlh') {
                $datasurvei['status'] = "4.1";
            } else if ($datasurvei['istansi'] == 'UPTDKPP') {
                $datasurvei['status'] = "4.2";
            } else if ($datasurvei['istansi'] == 'masyarakat') {
                $datasurvei['status'] = "4.3";
            } else if ($datasurvei['istansi'] == 'other') {
                $datasurvei['istansi'] = $request->input('other_istansi');
                $datasurvei['status'] = "4.3";
            } else {
                return redirect('/dashboard/admin/' . $slug)->with('gagal', 'Terdapat salah input');
            }
            $klhndata->update($datasurvei);
            $mess = "Berhasil mengubah rth menjadi status pelaksanaan";
        } else if ($klhndata->status == "4.1" || $klhndata->status == "4.2" || $klhndata->status == "4.3") {
            $validata2 = $request->validate([
                'tgl_pelaksanaan' =>
                [
                    'required',
                    'date',
                    'before_or_equal:today',
                    'after_or_equal:' . $klhndata->created_at->format('Y-m-d')
                ],
                'pelaksanaan' => ['array', 'min:1', 'required', new Totalsize],
                'pelaksanaan.*' => ['required', 'mimetypes:image/*,application/pdf', 'file'],
            ]);
            foreach ($request->file('pelaksanaan') as $photo) {
                $relativePath = 'foto/' . $slug . '/pelaksanaan';
                $filePath = $photo->store($relativePath, 'public');
                $databasePath = str_replace('public/', '', $filePath);
                $ftplksn['ftplksn'] = $databasePath;
                $ftplksn['slug'] = $slug;
                plksn::create($ftplksn);
            }
            $datasurvei['tgl_pelaksanaan'] = $validata2['tgl_pelaksanaan'];
            $datasurvei['status'] = "5";
            $klhndata->update($datasurvei);
            $mess = "Berhasil mengubah rth menjadi status selesai";
        } else {
            return redirect('/dashboard/admin/' . $slug)->with('gagal', 'Terdapat salah input');
        }
        $klhndata->touch();

        return redirect('/dashboard/admin/' . $slug)->with('status', $mess);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Klhn $klhn)
    {
        if (($klhn->uuid == auth()->user()->uuid) && ($klhn->status == 0 || $klhn->status == 1 || $klhn->status == 4.3)) {
            $slug = $klhn->slug;
            $fotos = $klhn->fotos;
            $lmrecs = $klhn->lmrecs;
            $fotoktp = $klhn->ftktp;
            $backUrl = '/dashboard/' . $slug;
            return view('users.user.ubahklhn', [
                'data' => $klhn,
                'fotos' => $fotos,
                'lmrecs' => $lmrecs,
                'fotoktp' => $fotoktp,
                'backUrl' => $backUrl,
            ]);
        } else {
            return redirect('/dashboard');
        }
    }

    public function updatedata(Klhn $klhn, Request $request)
    {
        if (auth()->user()->admin == "1") {
            $urlBack = "/dashboard/admin/";
        } else {
            $urlBack = "/dashboard/";
        }
        $stt = $request->input('stt');
        if ($stt != null) {
            return redirect($urlBack . $klhn->slug)->with('gagal', 'Data gagal diubah');
        }
        $datastt = $klhn->status;
        if ($datastt == "0" || $datastt == "1") {
            $validata1 = $request->validate([
                'nik' => ['required', 'numeric', 'digits:16'],
                'lat' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
                'long' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],            'loc_phnpt' => ['required'],
                'loc_phnpt' => ['nullable'],
                'loc_phntts' => ['required'],
                'alasan' => 'required',
            ]);
            $validatefotos = $request->validate([
                'fotos.*' => ['nullable', 'mimetypes:image/*,application/pdf', 'file'],
                'fotos' => ['array', 'min:1', 'nullable', new Totalsize],
                'ftktp' => ['nullable', 'mimetypes:image/*,application/pdf', 'file'],
                'addfotos.*' => ['nullable', 'mimetypes:image/*,application/pdf', 'file'],
                'lmrecs.*' => ['nullable', 'mimetypes:image/*,application/pdf', 'file'],
                'lmrecs' => ['array', 'min:1', 'nullable', new Totalsize],
                'addlmrec.*' => ['nullable', 'mimetypes:image/*,application/pdf', 'file'],
                'addlmrec' => ['array', 'min:1', 'nullable', new Totalsize]
            ]);
            $nikdb = $klhn->uuid;
            if (($nikdb == auth()->user()->uuid) || (auth()->user()->admin == "1")) {
                if ($validata1) {
                    $validata1['status'] = '1';
                    $validata1['note'] = '';
                    $klhn->update($validata1);
                }
                $seleclm = $klhn->lmrecs;
                $delelm = $request->input('deleted_lmrecs');
                if ($delelm == null && ($request->hasFile('addlmrec') != null)) {
                    $delelm[] = 999;
                    $seleclm[] = 998;
                } elseif (($delelm == null) && ($request->hasFile('addlmrec') == null)) {
                    return back()->with('gagal', 'Tidak dapat menghapus semua foto');
                }

                if ((count($seleclm) === count($delelm))) {
                } else {
                    for ($i = 0; $i < count($seleclm); $i++) {
                        $b1[] = $i;
                    }
                    $diff1 = array_diff($b1, $delelm);
                    foreach ($diff1 as $di1) {
                        if (isset($seleclm[$di1]) && is_object($seleclm[$di1])) {
                            $dellm = $seleclm[$di1];
                            unset($seleclm[$di1]);
                            $dellm->delete();
                            Storage::delete($dellm->lmrec);
                        }
                    }
                }

                $selectedft = $klhn->fotos;
                $deleted = $request->input('deleted_photos');
                if (($deleted == null) && ($request->hasFile('addfotos') != null)) {
                    $deleted[] = 999;
                    $selectedft[] = 998;
                } elseif (($deleted == null) && ($request->hasFile('addfotos') == null)) {
                    return back()->with('gagal', 'Tidak dapat menghapus semua foto');
                }

                if ((count($deleted) === count($selectedft))) {
                } else {
                    for ($i = 0; $i < count($selectedft); $i++) {
                        $b[] = $i;
                    }
                    $diff = array_diff($b, $deleted);
                    foreach ($diff as $di) {
                        if (isset($selectedft[$di]) && is_object($selectedft[$di])) {
                            $del = $selectedft[$di];
                            unset($selectedft[$di]);
                            $del->delete();
                            Storage::delete($del->ftphn);
                        }
                    }
                }

                if ($request->hasFile('fotos')) {
                    $changefotos = [];
                    $rths = $validatefotos['fotos'];
                    foreach ($selectedft as $oldFoto) {
                        $changefotos[] = $oldFoto;
                    }
                    $indexes = array_keys($rths);

                    for ($i = 0; $i < count($indexes); $i++) {
                        $changefoto = $changefotos[$indexes[$i]]->ftphn;
                        $newfotorth = $rths[$indexes[$i]];
                        $relativePath = 'foto/' . $klhn->slug . '/rth';
                        $filePath = $newfotorth->store($relativePath, 'public');
                        $databasePath = str_replace('public/', '', $filePath);
                        $ft = $changefotos[$indexes[$i]];

                        Storage::delete($changefoto);
                        $ft->update(['ftphn' => $databasePath]);
                    }
                }

                if ($request->hasFile('lmrecs')) {

                    $changelmrecs = [];
                    $lms = $validatefotos['lmrecs'];
                    foreach ($seleclm as $oldlm) {
                        $changelmrecs[] = $oldlm;
                    }
                    $indexeslm = array_keys($lms);

                    for ($i = 0; $i < count($indexeslm); $i++) {
                        $changelm = $changelmrecs[$indexeslm[$i]]->lmrec;
                        $newlm = $lms[$indexeslm[$i]];
                        $relativePathlm = 'foto/' . $klhn->slug . '/lm';
                        $filePathlm = $newlm->store($relativePathlm, 'public');
                        $databasePathlm = str_replace('public/', '', $filePathlm);
                        $ft = $changelmrecs[$indexeslm[$i]];

                        Storage::delete($changelm);
                        $ft->update(['lmrec' => $databasePathlm]);
                    }
                }



                if ($request->hasFile('addfotos')) {
                    $sizeFoto = $klhn->fotos;
                    $sizeAdd = $request->file('addfotos');
                    // Ganti nilai null dengan 999 dan hitung total size
                    $totalSize = 0;
                    if ($sizeFoto) {
                        foreach ($sizeFoto as $key => $photo) {
                            if (is_int($photo)) {
                                continue;
                            } else {
                                $totalSize += Storage::size($photo->ftphn); // Hitung total size foto
                            }
                        }
                    }
                    if ($sizeAdd) {
                        foreach ($sizeAdd as $file) {
                            $totalSize += $file->getSize(); // Hitung total size file yang di-upload
                        }
                    }
                    $totalSizeMB = $totalSize / (1024 * 1024);

                    if ($totalSizeMB > 2) {
                        return back()->with('gagal', 'Total ukuran foto melebihi 2mb.');
                    }

                    $newfotosrth = [];
                    foreach ($request->file('addfotos') as $newfoto) {
                        $relativePath = 'foto/' . $klhn->slug . '/rth';
                        $filePath = $newfoto->store($relativePath, 'public');
                        $databasePath = str_replace('public/', '', $filePath);
                        $newfotosrth[] = $databasePath;
                        ftphn::create([
                            'slug' => $klhn->slug,
                            'ftphn' => $databasePath
                        ]);
                    }
                }

                if ($request->hasFile('addlmrec')) {
                    $sizeFotolm = $klhn->lmrec;
                    $sizeAddlm = $request->file('lmrecs');

                    // Ganti nilai null dengan 999 dan hitung total size
                    $totalSize = 0;
                    if ($sizeFotolm) {
                        foreach ($sizeFotolm as $key => $photo) {
                            if (is_int($photo)) {
                                continue;
                            } else {
                                $totalSize += Storage::size($photo->ftphn); // Hitung total size foto
                            }
                        }
                    }

                    if ($sizeAddlm) {
                        foreach ($sizeAddlm as $file) {

                            $totalSize += $file->getSize(); // Hitung total size file yang di-upload
                        }
                    }
                    $totalSizeMB = $totalSize / (1024 * 1024);

                    if ($totalSizeMB > 2) {
                        return back()->with('gagal', 'Total ukuran foto melebihi 2mb.');
                    }

                    $newfotosrth = [];
                    foreach ($request->file('addlmrec') as $newfoto) {
                        $relativePath = 'foto/' . $klhn->slug . '/lm';
                        $filePath = $newfoto->store($relativePath, 'public');
                        $databasePath = str_replace('public/', '', $filePath);
                        $newfotosrth[] = $databasePath;
                        lmrecomen::create([
                            'slug' => $klhn->slug,
                            'lmrec' => $databasePath
                        ]);
                    }
                }

                if ($request->hasFile('ftktp')) {
                    $oldktp = $klhn->ftktp;
                    Storage::delete($oldktp);

                    $relativePath = 'foto/' . $klhn->slug . '/ktp';
                    $newktp = $request->file('ftktp');
                    $filePath = $newktp->store($relativePath, 'public');
                    $databasePath = str_replace('public/', '', $filePath);
                    $klhn->update(['ftktp' => $databasePath]);
                }
                $klhn->touch();


                return redirect($urlBack . $klhn->slug)->with('berhasil', 'Data Berhasil diubah');
            } else {
                return redirect($urlBack . $klhn->slug)->with('gagal', 'Data Gagal diubah');
            }
        } elseif ($datastt == "4.3") {
            $validata2 = $request->validate([
                'tgl_pelaksanaan' => [
                    'required',
                    'date',
                    'before_or_equal:today',
                    'after_or_equal:' . $klhn->created_at->format('Y-m-d')
                ],
                'pelaksanaan' => ['array', 'min:1', 'required'],
                'pelaksanaan.*' => ['required', 'mimetypes:image/*,application/pdf', 'file'],
            ]);
            $slug = $klhn->slug;
            foreach ($request->file('pelaksanaan') as $photo) {
                $relativePath = 'foto/' . $slug . '/pelaksanaan';
                $filePath = $photo->store($relativePath, 'public');
                $databasePath = str_replace('public/', '', $filePath);
                $ftplksn['ftplksn'] = $databasePath;
                $ftplksn['slug'] = $slug;
                plksn::create($ftplksn);
            }
            $datasurvei['tgl_pelaksanaan'] = $validata2['tgl_pelaksanaan'];
            $datasurvei['status'] = "5";
            $klhn->update($datasurvei);
            $klhn->touch();
            return redirect($urlBack . $klhn->slug)->with('berhasil', 'Data pelaksanaan berhasil ditambah');
        } else {
            return redirect($urlBack . $klhn->slug)->with('gagal', 'Data Gagal diubah');
        }
    }
    public function backup(klhn $klhn, Request $request)
    {
        if ($klhn->status != "1" && $klhn->status != "0") {
            return back()->with('gagal', 'Data tidak dapat dihapus.');
        }
        $user = auth()->user();
        $isAdmin = $user->admin == "1";
        $isOwner = $user->uuid === $klhn->uuid;

        $redirectPath = $isAdmin ? "/dashboard/admin" : "/dashboard";

        if ($isOwner || $isAdmin) {
            backup::insert([
                'kd_hapus' => $klhn->slug,
                'waktu_hapus' => now()
            ]);
            return redirect($redirectPath)->with('berhasil', 'Data berhasil dihapus');
        } else {
            return redirect($redirectPath)->with('gagal', 'Data gagal dihapus');
        }
    }
    public function hapus(Request $request)
    {
        $time = Carbon::now()->subMicrosecond();

        $oldBackups = backup::where('waktu_hapus', '<', $time)->where('terhapus', '0')->get();
        $countdata = count($oldBackups);
        foreach ($oldBackups as $backup) {
            $slug = $backup->kd_hapus;
            $folderPath = '/foto/' . $slug;
            $klhn = klhn::where('slug', $slug)->first();
            if ($klhn) {
                $klhn->fotos()->delete();
                $klhn->surats()->delete();
                $klhn->lmrecs()->delete();
                $klhn->surveis()->delete();
                $klhn->plksns()->delete();

                // Hapus entri di tabel `klhn`
                $klhn->delete();

                // Nonaktifkan timestamps sebelum update
                $backup->timestamps = false;
                $backup->update(['terhapus' => '1']);
                $backup->timestamps = true;
            }
            if (Storage::exists($folderPath)) {
                Storage::deleteDirectory($folderPath);
            } else {
            }
        }

        return redirect('/dashboard/admin/arsip')->with('berhasil', $countdata . ' Data berhasil dihapus.');
    }
}
