<?= form_open('periode/tambah', array('id' => 'formPeriode')); ?>
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-3">Nama</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama">
    </div>
</div>
<?= form_close(); ?>
<div id="result"></div>

<script>
    $(document).ready(function(){
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<button type="button" class="btn btn-primary" id="Yes">Simpan Data</button>';
        $('#ModalFooter').html(btn);

        $('#Yes').click(function(e){
            e.preventDefault();

            $.ajax({
                url: $('#formPeriode').attr('action'),
                type: 'POST',
                data: $('#formPeriode').serialize(),
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
                            $('#tablePeriode').DataTable().ajax.reload(null, false);
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