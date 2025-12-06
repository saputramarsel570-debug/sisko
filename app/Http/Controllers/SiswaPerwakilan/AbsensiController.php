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

        $periode = $request->get('periode', 'hari');
        $tanggal = $request->get('tanggal', now()->toDateString());
        $bulan   = $request->get('bulan', now()->format('Y-m'));

        // Deteksi libur + tanggal future
        $isWeekend = in_array(Carbon::parse($tanggal)->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
        $isFuture  = Carbon::parse($tanggal)->gt(Carbon::today());

        // tanggalList
        if ($periode === 'hari') {
            $tanggalList = [$tanggal];

        } else {
            $start = Carbon::parse("$bulan-01");
            $until = $start->copy()->endOfMonth();

            $tanggalList = [];
            while ($start->lte($until)) {
                $tanggalList[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        $siswaList = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

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
            'kelasId',
            'isWeekend',
            'isFuture',
        ));
    }

    public function updateBulk(Request $request)
    {
        $tanggal = $request->tanggal;

        // Cegah hari libur
        if (in_array(Carbon::parse($tanggal)->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
            return back()->withErrors(['Hari ini adalah hari libur (Sabtu atau Minggu). Tidak dapat melakukan absensi.']);
        }

        // Cegah tanggal future
        if (Carbon::parse($tanggal)->gt(Carbon::today())) {
            return back()->withErrors(['Tidak boleh melakukan absensi untuk tanggal yang belum terjadi.']);
        }

        $kelasId = $request->kelas_id;
        $absensiData = $request->absensi ?? [];

        $siswaList = Siswa::whereIn('id', array_keys($absensiData))
            ->pluck('nama', 'id');

        $rules = [];
        $attributes = [];

        foreach ($absensiData as $id => $data) {
            $nama = $siswaList[$id] ?? 'Siswa';

            $rules["absensi.$id.status"] = "required|in:hadir,izin,sakit,alfa";

            if (in_array($data['status'] ?? null, ['izin', 'sakit'])) {
                $rules["absensi.$id.keterangan"] = "required|string";
            }

            $attributes["absensi.$id.status"] = "Status untuk $nama";
            $attributes["absensi.$id.keterangan"] = "Keterangan untuk $nama";
        }

        $validator = Validator::make($request->all(), $rules);
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

        return back()->with('success', 'Absensi berhasil diperbarui.');
    }

    public function hadirSemua(Request $request)
    {
        $tanggal = $request->tanggal;

        if (in_array(Carbon::parse($tanggal)->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
            return back()->withErrors(['Hari ini adalah hari libur (Sabtu atau Minggu). Tidak dapat mengubah absensi.']);
        }

        if (Carbon::parse($tanggal)->gt(Carbon::today())) {
            return back()->withErrors(['Tidak boleh mengubah absensi untuk tanggal yang belum terjadi.']);
        }

        $kelasId = $request->kelas_id;
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
            $until = $start->copy()->endOfMonth();

            $query->whereBetween('tanggal', [$start->toDateString(), $until->toDateString()]);
        }

        $absensi = $query->get();

        if ($periode === 'bulan') {
            $start = Carbon::parse("$bulan-01");
            $until = $start->copy()->endOfMonth();

            $tanggalList = [];
            while ($start->lte($until)) {
                $tanggalList[] = $start->format('Y-m-d');
                $start->addDay();
            }
        } else {
            $tanggalList = [$tanggal];
        }

        $rekap = [];
        foreach ($absensi as $a) {
            $rekap[$a->siswa_id][$a->tanggal] = $a;
        }

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