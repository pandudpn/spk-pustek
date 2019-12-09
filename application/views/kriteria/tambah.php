<?= form_open('kriteria/tambah/', array('id' => 'formKriteria')); ?>
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-3">Nama</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama">
    </div>
</div>
<div class="form-group row">
    <label for="bobot" class="col-form-label col-md-3">Bobot</label>
    <div class="col-md-9">
        <input type="number" class="form-control" id="bobot" name="bobot" max="0.9999" min="0.0001" step=".0001" placeholder="Masukan Nilai Bobot">
    </div>
</div>
<div class="form-group row">
    <label for="bobot" class="col-form-label col-md-3">Cost atau Benefit</label>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <div class="radio">
                    <label for="cost">
                        <input type="radio" name="cb" value="cost" id="cost" checked>
                        Cost
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="radio">
                    <label for="benefit">
                        <input type="radio" name="cb" value="benefit" id="benefit">
                        Benefit
                    </label>
                </div>
            </div>
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

        $('#Yes').click(function(e){
            e.preventDefault();

            $.ajax({
                url: $('#formKriteria').attr('action'),
                type: 'POST',
                data: $('#formKriteria').serialize(),
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
                            $('#tableKriteria').DataTable().ajax.reload(null, false);
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