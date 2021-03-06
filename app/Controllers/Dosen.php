<?php

namespace App\Controllers;

class Dosen extends BaseController
{
    public function index()
    {
        if (session()->get('level') <> 2) {
            return redirect()->to('dashboard');
        }
        $data = [
            'title' => 'dosen - STMIK METRO'
        ];
        return view('auth/dosen/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'List dosen - STMIK METRO',
                'list' => $this->dosen->list()


            ];
            $msg = [
                'data' => view('auth/dosen/list', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah dosen',
                'mapel' => $this->mapel->orderBy('nama_mapel', 'ASC')->findAll()
            ];
            $msg = [
                'data' => view('auth/dosen/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nip' => [
                    'label' => 'Nip',
                    'rules' => 'required|is_unique[dosen.nip]|min_length[10]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                        'min_length' => '{field} minimal 10',
                    ]
                ],
                'nama' => [
                    'label' => 'Nama dosen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tmp_lahir' => [
                    'label' => 'Tempat Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'mapel_id' => [
                    'label' => 'Nama Mapel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pendidikan' => [
                    'label' => 'Pendidikan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nip' => $validation->getError('nip'),
                        'nama' => $validation->getError('nama'),
                        'tmp_lahir' => $validation->getError('tmp_lahir'),
                        'tgl_lahir' => $validation->getError('tgl_lahir'),
                        'mapel_id' => $validation->getError('mapel_id'),
                        'pendidikan' => $validation->getError('pendidikan'),
                        'alamat' => $validation->getError('alamat')
                    ]
                ];
            } else {
                $simpandata = [
                    'nip' => $this->request->getVar('nip'),
                    'nama' => $this->request->getVar('nama'),
                    'tmp_lahir' => $this->request->getVar('tmp_lahir'),
                    'tgl_lahir' => $this->request->getVar('tgl_lahir'),
                    'mapel_id' => $this->request->getVar('mapel_id'),
                    'pendidikan' => $this->request->getVar('pendidikan'),
                    'alamat' => $this->request->getVar('alamat'),
                    'foto' => $this->request->getVar('foto'),
                ];

                $this->dosen->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $dosen_id = $this->request->getVar('dosen_id');
            $list =  $this->dosen->find($dosen_id);
            $mapel =  $this->mapel->list();
            $data = [
                'title'         => 'Edit dosen',
                'mapel'         => $mapel,
                'dosen_id'       => $list['dosen_id'],
                'nip'           => $list['nip'],
                'nama'          => $list['nama'],
                'tmp_lahir'     => $list['tmp_lahir'],
                'tgl_lahir'     => $list['tgl_lahir'],
                'mapel_id'      => $list['mapel_id'],
                'pendidikan'    => $list['pendidikan'],
                'alamat'        => $list['alamat'],
            ];
            $msg = [
                'sukses' => view('auth/dosen/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nip' => [
                    'label' => 'Nip',
                    'rules' => 'required|min_length[10]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} minimal 10',
                    ]
                ],
                'nama' => [
                    'label' => 'Nama dosen',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tmp_lahir' => [
                    'label' => 'Tempat Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_lahir' => [
                    'label' => 'Tanggal Lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'mapel_id' => [
                    'label' => 'Nama Mapel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pendidikan' => [
                    'label' => 'Pendidikan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nip' => $validation->getError('nip'),
                        'nama' => $validation->getError('nama'),
                        'tmp_lahir' => $validation->getError('tmp_lahir'),
                        'tgl_lahir' => $validation->getError('tgl_lahir'),
                        'mapel_id' => $validation->getError('mapel_id'),
                        'pendidikan' => $validation->getError('pendidikan'),
                        'alamat' => $validation->getError('alamat')
                    ]
                ];
            } else {
                $updatedata = [
                    'nip' => $this->request->getVar('nip'),
                    'nama' => $this->request->getVar('nama'),
                    'tmp_lahir' => $this->request->getVar('tmp_lahir'),
                    'tgl_lahir' => $this->request->getVar('tgl_lahir'),
                    'mapel_id' => $this->request->getVar('mapel_id'),
                    'pendidikan' => $this->request->getVar('pendidikan'),
                    'alamat' => $this->request->getVar('alamat'),
                ];

                $dosen_id = $this->request->getVar('dosen_id');
                $this->dosen->update($dosen_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $dosen_id = $this->request->getVar('dosen_id');
            //check
            $cekdata = $this->dosen->find($dosen_id);
            $fotolama = $cekdata['foto'];
            if ($fotolama != 'default.png') {
                unlink('img/dosen/' . $fotolama);
                unlink('img/dosen/thumb/' . 'thumb_' . $fotolama);
            }
            $this->dosen->delete($dosen_id);
            $msg = [
                'sukses' => 'Data dosen Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $dosen_id = $this->request->getVar('dosen_id');
            $jmldata = count($dosen_id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->dosen->find($dosen_id[$i]);
                $fotolama = $cekdata['foto'];
                if ($fotolama != 'default.png') {
                    unlink('img/dosen/' . $fotolama);
                    unlink('img/dosen/thumb/' . 'thumb_' . $fotolama);
                }
                $this->dosen->delete($dosen_id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }

    public function formupload()
    {
        if ($this->request->isAJAX()) {
            $dosen_id = $this->request->getVar('dosen_id');
            $list =  $this->dosen->find($dosen_id);
            $data = [
                'title' => 'Upload Foto dosen',
                'list'  => $list,
                'dosen_id' => $dosen_id
            ];
            $msg = [
                'sukses' => view('auth/dosen/upload', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function doupload()
    {
        if ($this->request->isAJAX()) {

            $dosen_id = $this->request->getVar('dosen_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'foto' => [
                    'label' => 'Upload foto',
                    'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'foto' => $validation->getError('foto')
                    ]
                ];
            } else {

                //check
                $cekdata = $this->dosen->find($dosen_id);
                $fotolama = $cekdata['foto'];
                if ($fotolama != 'default.png') {
                    unlink('img/dosen/' . $fotolama);
                    unlink('img/dosen/thumb/' . 'thumb_' . $fotolama);
                }

                $filefoto = $this->request->getFile('foto');

                $updatedata = [
                    'foto' => $filefoto->getName()
                ];

                $this->dosen->update($dosen_id, $updatedata);

                \Config\Services::image()
                    ->withFile($filefoto)
                    ->fit(250, 250, 'center')
                    ->save('img/dosen/thumb/' . 'thumb_' .  $filefoto->getName());
                $filefoto->move('img/dosen');
                $msg = [
                    'sukses' => 'Foto berhasil diupload!'
                ];
            }
            echo json_encode($msg);
        }
    }




    //Start mapel (backend)
    public function mapel()
    {
        if (session()->get('level') <> 2) {
            return redirect()->to('/dashboard');
        }
        $data = [
            'title' => 'Mapel - STMIK METRO'
        ];
        return view('auth/mapel/index', $data);
    }

    public function getmapel()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'dosen - Mapel',
                'list' => $this->mapel->orderBy('mapel_id', 'ASC')->findAll()
            ];
            $msg = [
                'data' => view('auth/mapel/list', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formmapel()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Mapel'
            ];
            $msg = [
                'data' => view('auth/mapel/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanmapel()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_mapel' => [
                    'label' => 'Mapel',
                    'rules' => 'required|is_unique[mapel.nama_mapel]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_mapel' => $validation->getError('nama_mapel'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_mapel' => $this->request->getVar('nama_mapel'),
                ];

                $this->mapel->insert($simpandata);
                $msg = [
                    'sukses' => 'Data berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditmapel()
    {
        if ($this->request->isAJAX()) {
            $mapel_id = $this->request->getVar('mapel_id');
            $list =  $this->mapel->find($mapel_id);
            $data = [
                'title'           => 'Edit Mapel',
                'mapel_id'        => $list['mapel_id'],
                'nama_mapel'      => $list['nama_mapel'],
            ];
            $msg = [
                'sukses' => view('auth/mapel/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function updatemapel()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_mapel' => [
                    'label' => 'Mapel',
                    'rules' => 'required|is_unique[mapel.nama_mapel]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_mapel' => $validation->getError('nama_mapel'),
                    ]
                ];
            } else {
                $updatedata = [
                    'nama_mapel' => $this->request->getVar('nama_mapel'),
                ];

                $mapel_id = $this->request->getVar('mapel_id');
                $this->mapel->update($mapel_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapusmapel()
    {
        if ($this->request->isAJAX()) {

            $mapel_id = $this->request->getVar('mapel_id');

            $this->mapel->delete($mapel_id);
            $msg = [
                'sukses' => 'Mapel Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }
    //end mapel
}
