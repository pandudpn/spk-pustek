<?php if($cek->num_rows() == 0){ ?>
    <?= form_open('analisa/hasilkeputusan/'.$tahun, array('id' => 'formKeputusan')); ?>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th><center>No</center></th>
                <th><center>Nama Guru</center></th>
                <th><center>Nilai Akhir</center></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach($hasil->result() AS $data){ ?>
            <tr>
                <td><center><?= $no++; ?></center></td>
                <td><center><?= $data->nama_guru; ?></center></td>
                <th><center><?= number_format($data->nilai_akhir, 4, ',','.'); ?></center></th>
                <td>
                    <center>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="<?= $data->kode_guru; ?>" name="guru" class="custom-control-input" value="<?= $data->kode_guru; ?>">
                        <label class="custom-control-label mt-1" for="<?= $data->kode_guru; ?>">Pilih</label>
                    </div>
                    </center>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <button class="btn btn-primary mt-3 float-right" id="simpan">Simpan Data</button>
    <?= form_close(); ?>
<?php } else{ ?>
    <h2 class="text-center text-danger"><i>Tidak ada Data yang tersedia atau Tahun Ajaran tersebut sudah memiliki Guru Terbaik!</i></h2>
<?php } ?>

<script>
    $(document).ready(function(){
        $('#formKeputusan').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    $('#simpan').html('<i class="mdi mdi-loading mdi-spin"> Menunggu respon server.....</i>');
                    $('#simpan').addClass('disabled');
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status === 'success'){
                            $('.modal-dialog').addClass('modal-sm');
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<a href="<?php echo base_url(); ?>analisa/pilih" class="btn btn-secondary">Ok</a>');
                            $('#ModalGue').modal('show');
                            $('#simpan').html('Simpan Data');
                            $('#simpan').removeClass('disabled');
                        }else if(data.status === 'error'){
                            $('#ModalHeader').html('Error');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>');
                            $('#ModalGue').modal('show');
                            $('#simpan').html('Simpan Data');
                            $('#simpan').removeClass('disabled');
                        }
                    }, 1000);
                }
            })
        })
    })
</script>