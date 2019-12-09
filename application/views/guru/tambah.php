<?= form_open('guru/tambah', array('id' => 'formGuru')); ?>
<div class="form-group row">
    <label for="kode_guru" class="col-form-label col-md-3">Kode Guru</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="kode_guru" name="kode_guru" placeholder="Masukan Kode Guru">
        <div id="cek_kode"></div>
    </div>
</div>
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-3">Nama</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama">
    </div>
</div>
<div class="form-group row">
    <label for="telp" class="col-form-label col-md-3">Telepon</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="telp" name="telp" placeholder="Masukan Telepon">
    </div>
</div>
<div class="form-group row">
    <label for="alamat" class="col-form-label col-md-3">Alamat</label>
    <div class="col-md-9">
        <textarea name="alamat" id="alamat" cols="5" rows="5" class="form-control" placeholder="Masukan Alamat Guru"></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="pendidikan" class="col-form-label col-md-3">Jenis Guru</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="pendidikan" name="pendidikan" placeholder="Jenis Guru">
    </div>
</div>
<div class="form-group row">
    <label for="ttl" class="col-form-label col-md-3">TTL</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Tempat Lahir">
    </div>
    <div class="col-md-4">
        <input type="text" class="form-control" id="tgl" name="tgl" placeholder="Tanggal Lahir">
    </div>
</div>
<div class="form-group row">
    <label for="pendidikan" class="col-form-label col-md-3">Jenis Kelamin</label>
    <div class="col-md-4">
        <div class="radio">
            <label for="laki-laki">
                <input type="radio" name="jk" value="Laki-laki" id="laki-laki"> Laki-laki
            </label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="radio">
            <label for="perempuan">
                <input type="radio" name="jk" value="Perempuan" id="perempuan"> Perempuan
            </label>
        </div>
    </div>
</div>
<?= form_close(); ?>
<div id="result"></div>

<script>
    $(document).ready(function(){
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<button type="button" class="btn btn-primary" id="Yes">Simpan Data</button>';
        $('#ModalFooter').html(btn);

        $('#tgl').datetimepicker({
            format: 'Y-m-d',
            timepicker: false
        });

        $('#Yes').click(function(e){
            e.preventDefault();

            $.ajax({
                url: $('#formGuru').attr('action'),
                type: 'POST',
                data: $('#formGuru').serialize(),
                dataType: 'json',
                cache: false,
                beforeSend: function(){
                    $('#Yes').html('<i class="mdi mdi-loading mdi-spin">Sendang memproses data ke server.....</i>');
                    $('#Yes').addClass('disabled');
                },
                success: function(data){
                    setTimeout(() => {
                        if(data.status === 'success'){
                            $('#Yes').html('Simpan Data');
                            $('#Yes').removeClass('disabled');
                            $('#ModalGue').modal('hide');
                            $('#Notifikasi').html(data.pesan);
                            $('#Notifikasi').fadeIn('fast').show().delay(4000).fadeOut('slow');
                            $('#tableGuru').DataTable().ajax.reload(null, false);
                        }else{
                            $('#Yes').html('Simpan Data');
                            $('#Yes').removeClass('disabled');
                            $('#result').html(data.pesan);
                            $('#result').fadeIn('fast').show().delay(4000).fadeOut('slow');
                        }
                    }, 2000);
                }
            })
        })
    })
</script>