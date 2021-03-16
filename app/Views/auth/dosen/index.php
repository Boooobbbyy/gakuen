<?= $this->extend('auth/layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title">dosen </h4>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-right">
        <li class="breadcrumb-item"><a href="javascript:void(0);">dosen</a></li>
        <li class="breadcrumb-item active">List dosen</li>
        <li class="breadcrumb-item"><a href="<?= site_url('auth/dosen/mapel') ?>">Mapel</a></li>
    </ol>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<p class="sub-title"> <button type="button" class="btn btn-primary btn-sm tambahdosen"><i class=" fa fa-plus-circle"></i> Tambah dosen</button>
    <br>
    <small> <i class="fa fa-info-circle"></i> Klik foto untuk memperbarui foto!</small>
</p>
<div class="viewdata">
</div>

<div class="viewmodal">
</div>


<script>
    function listdosen() {
        $.ajax({
            url: "<?= site_url('dosen/getdata') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            }
        });
    }

    $(document).ready(function() {
        listdosen();
        $('.tambahdosen').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('dosen/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();

                    $('#modaltambah').modal('show');
                }
            });
        });
    });
</script>
<?= $this->endSection('isi') ?>