<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelppdb extends Model
{
    protected $table      = 'ppdb';
    protected $primaryKey = 'ppdb_id';
    protected $allowedFields = [
        'nisn',
        'password',
        'nama_lengkap',
        'tgl_lahir',
        'tmp_lahir',
        'jenkel',
        'asal_sekolah',
        'nama_ayah',
        'nama_ibu',
        'alamat',
        'no_telp',
        'jurusan',
        'foto_siswa',
        'foto_ijazah',
        'tgl_daftar',
        'agama',
        'jenis_tinggal',
        'transportasi',
        'status',
        'mapel_id',
        'nilai'
    ];

    public function getsiswa($id)
    {
        return $this->table('ppdb')
            ->join('mapel', 'mapel.mapel_id = ppdb.mapel_id')
            ->like('status', 'lulus')
            ->where('ppdb_id', $id)
            ->get()->getRow();
    }
}
