<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldosen extends Model
{
    protected $table      = 'dosen';
    protected $primaryKey = 'dosen_id';
    protected $allowedFields = ['nip', 'nama', 'tmp_lahir', 'tgl_lahir', 'mapel_id', 'pendidikan', 'alamat', 'foto'];

    //backend
    public function list()
    {
        return $this->table('dosen')
            ->join('mapel', 'mapel.mapel_id = dosen.mapel_id')
            ->orderBy('dosen_id', 'ASC')
            ->get()->getResultArray();
    }
}
