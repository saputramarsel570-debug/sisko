<?php

namespace App\Exports\SiswaPerwakilan;

use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JadwalPelajaranExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $kelasId;

    public function __construct($kelasId = null)
    {
        $this->kelasId = $kelasId;
    }

    public function collection()
    {
        return JadwalPelajaran::with(['kelas', 'mataPelajaran', 'guru'])
            ->when($this->kelasId, fn($q) => $q->where('kelas_id', $this->kelasId))
            ->get();
    }

    public function map($jadwal): array
    {
        return [
            $jadwal->id,
            $jadwal->kelas->nama_kelas ?? '-',
            $jadwal->mataPelajaran->nama_mapel ?? '-',
            $jadwal->guru->nama ?? '-',
            $jadwal->hari,
            $jadwal->jam_mulai,
            $jadwal->jam_selesai,
            $jadwal->created_at ? $jadwal->created_at->format('Y-m-d H:i') : '-',
            $jadwal->updated_at ? $jadwal->updated_at->format('Y-m-d H:i') : '-',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kelas',
            'Mata Pelajaran',
            'Guru',
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
            'Dibuat',
            'Update Terakhir',
        ];
    }
}