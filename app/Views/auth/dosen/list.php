<?= form_open('dosen/hapusall', ['class' => 'formhapus']) ?>

<button type="submit" class="btn btn-danger btn-sm">
    <i class="fa fa-trash"></i> Hapus yang diceklist
</button>

<hr>
<table id="listdosen" class="table table-striped dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="centangSemua">
            </th>
            <th>#</th>
            <th>Nip</th>
            <th>Nama</th>
            <th>Tempat & Tgl Lahir</th>
            <th>Mapel</th>
            <th>Alamat</th>
            <th>Pendidikan</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>


    <tbody>
        <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td>
                    <input type="checkbox" name="dosen_id[]" class="centangdosenid" value="<?= $data['dosen_id'] ?>">
                </td>
                <td><?= $nomor ?></td>
                <td><?= esc($data['nip']) ?></td>
                <td><?= esc($data['nama']) ?></td>
                <td><?= esc($data['tmp_lahir']) ?>, <?= esc($data['tgl_lahir']) ?></td>
                <td><?= esc($data['nama_mapel']) ?></td>
                <td><?= esc($data['alamat']) ?></td>
                <td><?= esc($data['pendidikan']) ?></td>

                <td class="text-center"><img onclick="gambar('<?= $data['dosen_id'] ?>')" src="<?= base_url('img/dosen/thumb/' . 'thumb_' . $data['foto']) ?>" width="120px" class="img-thumbnail"></td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" onclick="edit('<?= $data['dosen_id'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $data['dosen_id'] ?>')">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<?= form_close() ?>
<script>
    $(document).ready(function() {
        $('#listdosen').DataTable({

        });
        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangdosenid').prop('checked', true);
            } else {
                $('.centangdosenid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangdosenid:checked');
            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'Silahkan pilih data!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                Swal.fire({
                    title: 'Hapus data',
                    text: `Apakah anda yakin ingin menghapus sebanyak ${jmldata.length} data?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                listdosen();
                            }
                        });
                    }
                })
            }
        });
    });




    function edit(dosen_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('dosen/formedit') ?>",
            data: {
                dosen_id: dosen_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function hapus(dosen_id) {
        Swal.fire({
            title: 'Hapus data?',
            text: `Apakah anda yakin menghapus data?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('dosen/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        dosen_id: dosen_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.sukses,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            listdosen();
                        }
                    }
                });
            }
        })
    }

    function gambar(dosen_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('dosen/formupload') ?>",
            data: {
                dosen_id: dosen_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalupload').modal('show');
                }
            }
        });
    }
</script>