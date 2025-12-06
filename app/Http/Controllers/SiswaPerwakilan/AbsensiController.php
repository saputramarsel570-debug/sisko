<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Validator;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        return $this->rekap($request);
    }

    public function rekap(Request $request)
    {
        $user = auth()->user();
        $kelasId = optional($user->siswa->kelas)->id;

        if (!$kelasId) {
            return back()->with('error', 'Data kelas siswa perwakilan tidak ditemukan.');
        }

        // periode: hari/bulan
        $periode = $request->get('periode', 'hari');
        $tanggal = $request->get('tanggal', now()->toDateString());
        $bulan   = $request->get('bulan', now()->format('Y-m'));

        // ===============================
        //  SAFE TANGGALLIST (NO CARBON PERIOD)
        // ===============================
        if ($periode === 'hari') {
            $tanggalList = [$tanggal];
        } else {
            $start = Carbon::parse("$bulan-01");
            $end   = $start->copy()->endOfMonth();

            $tanggalList = [];
            while ($start->lte($end)) {
                $tanggalList[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        // ===============================
        //  AMAN UNTUK BULANAN
        // ===============================
        $siswaList = Siswa::where('kelas_id', $kelasId)
            ->orderBy('nama')
            ->get();

        $absensi = Absensi::whereIn('siswa_id', $siswaList->pluck('id'))
            ->whereBetween('tanggal', [reset($tanggalList), end($tanggalList)])
            ->get();

        $rekap = [];
        $totalStatus = [];

        foreach ($absensi as $a) {
            $rekap[$a->siswa_id][$a->tanggal] = $a;

            $status = strtolower($a->status);
            $totalStatus[$a->siswa_id][$status] =
                ($totalStatus[$a->siswa_id][$status] ?? 0) + 1;
        }

        return view('pages.siswa_perwakilan.absensi.rekap', compact(
            'siswaList',
            'rekap',
            'tanggalList',
            'periode',
            'tanggal',
            'bulan',
            'totalStatus',
            'kelasId'
        ));
    }

    public function updateBulk(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tanggal = $request->tanggal;
        $absensiData = $request->absensi ?? [];

        // Ambil nama siswa untuk label validasi
        $siswaList = Siswa::whereIn('id', array_keys($absensiData))
            ->pluck('nama', 'id');

        $rules = [];
        $messages = [
            'required' => ':attribute wajib diisi.',
            'in'       => ':attribute harus salah satu dari: hadir, izin, sakit, alfa.',
            'string'   => ':attribute harus berupa teks.',
        ];

        $attributes = [];

        foreach ($absensiData as $id => $data) {
            $nama = $siswaList[$id] ?? "Siswa";

            $rules["absensi.$id.status"] = "required|in:hadir,izin,sakit,alfa";

            if (in_array($data['status'] ?? null, ['izin', 'sakit'])) {
                $rules["absensi.$id.keterangan"] = "required|string";
            }

            $attributes["absensi.$id.status"] = "Status untuk $nama";
            $attributes["absensi.$id.keterangan"] = "Keterangan untuk $nama";
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->setAttributeNames($attributes);
        $validator->validate();

        foreach ($absensiData as $id => $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $id,
                    'tanggal'  => $tanggal
                ],
                [
                    'kelas_id'   => $kelasId,
                    'status'     => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('siswa_perwakilan.absensi.rekap', [
                'kelas_id' => $kelasId,
                'periode'  => 'hari',
                'tanggal'  => $tanggal,
            ])
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function hadirSemua(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tanggal = $request->tanggal;

        $siswaList = Siswa::where('kelas_id', $kelasId)->pluck('id');

        foreach ($siswaList as $sid) {
            Absensi::updateOrCreate(
                ['siswa_id' => $sid, 'tanggal' => $tanggal],
                ['kelas_id' => $kelasId, 'status' => 'hadir', 'keterangan' => null]
            );
        }

        return back()->with('success', 'Status seluruh siswa ditandai sebagai HADIR.');
    }

    public function exportPdf(Request $request)
    {
        $kelasId = $request->kelas_id;
        $periode = $request->periode;
        $bulan   = $request->bulan;
        $tanggal = now()->toDateString();

        $kelas = Kelas::findOrFail($kelasId);
        $siswaList = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

        $query = Absensi::where('kelas_id', $kelasId);

        if ($periode === 'hari') {
            $query->whereDate('tanggal', $tanggal);
        } else {
            $start = Carbon::parse("$bulan-01");
            $end = $start->copy()->endOfMonth();

            $query->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()]);
        }

        $absensi = $query->get();

        // tanggalList aman
        if ($periode === 'bulan') {
            $start = Carbon::parse("$bulan-01");
            $end   = $start->copy()->endOfMonth();

            $tanggalList = [];
            while ($start->lte($end)) {
                $tanggalList[] = $start->format('Y-m-d');
                $start->addDay();
            }
        } else {
            $tanggalList = [$tanggal];
        }

        // rekap
        $rekap = [];
        foreach ($absensi as $a) {
            $rekap[$a->siswa_id][$a->tanggal] = $a;
        }

        // total status
        $totalStatus = [];
        foreach ($siswaList as $s) {
            $totalStatus[$s->id] = [
                'hadir' => $absensi->where('siswa_id', $s->id)->where('status', 'hadir')->count(),
                'sakit' => $absensi->where('siswa_id', $s->id)->where('status', 'sakit')->count(),
                'izin'  => $absensi->where('siswa_id', $s->id)->where('status', 'izin')->count(),
                'alfa'  => $absensi->where('siswa_id', $s->id)->where('status', 'alfa')->count(),
            ];
        }

        $pdf = Pdf::loadView('pages.siswa_perwakilan.absensi.pdf', compact(
            'kelas',
            'siswaList',
            'rekap',
            'tanggalList',
            'totalStatus',
            'periode',
            'bulan',
            'tanggal',
        ))->setPaper('a4', 'landscape');

        return $pdf->download('Rekap-Absensi-' . $kelas->nama_kelas . '.pdf');
    }
}