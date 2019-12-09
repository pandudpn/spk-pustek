<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Perhitungan</h4>
            <hr>
            <br>
            <!-- bagian atas -->
            <div class="row">
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="ta" class="col-form-label col-md-4 col-sm-4 col-4">Tahun Ajaran</label>
                        <div class="col-md-8 col-sm-8 col-8">
                            <select name="ta" id="ta" class="form-control">
                                <option value="" selected disabled>-</option>
                                <?php foreach($periode AS $data){ ?>
                                <option value="<?= $data->id_periode; ?>"><?php echo $data->nama_periode ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-12">
                    <div class="form-group row">
                        <label for="gur" class="col-form-label col-md-4 col-sm-4 col-4">Nama Guru</label>
                        <div class="col-md-8 col-sm-8 col-8">
                            <select name="gur" id="gur" class="form-control">
                                <option value="" selected disabled>-</option>
                                <?php foreach($guru AS $gurus){ ?>
                                <option value="<?= $gurus->kode_guru; ?>"><?= $gurus->nama_guru; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .// bagian atas -->
            <br>
            <!-- table -->
            <?php echo form_open('analisa/perhitungan', array('id' => 'formNilai')); ?>
            <!-- <input type="text" name="nilai_akhir" id="nilai_akhir"> -->
            <table class="table table-responsive table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="5%"><center>No</center></th>
                        <th><center>Nama</center></th>
                        <th width="30%"><center>Nilai</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $n  = 1;
                    $o  = 1;
                    foreach($kriteria AS $row){ ?>
                        <tr>
                            <th colspan="3">
                                <?= $row->nama_kriteria; ?>
                            </th>
                        </tr>
                        <?php foreach($subkriteria AS $data){
                            if($data->id_kriteria == $row->id_kriteria){ ?>
                            <tr>
                                <td><center><?= $no++; ?></center></td>
                                <td>
                                    <?= $data->nama_subkriteria; ?>
                                </td>
                                <td width="30%"><center>
                                    <input style="width: 70px;" type="number" min="1" max="5" name="nilai[]" class="form-control sub_<?= $row->id_kriteria; ?>" required />
                                </center></td>
                            </tr>
                            <?php }
                        } ?>
                        <tr>
                            <td colspan="2">
                                <center>
                                    Total Nilai Kriteria - <b><?= $row->nama_kriteria; ?></b>
                                    <input type="hidden" class="loopGuru" name="guru[]" />
                                    <input type="hidden" name="kriteria[]" value="<?php echo $row->id_kriteria; ?>" />
                                    <input type="hidden" class="loopTahun" name="tahunajaran[]" />
                                    <input type="hidden" class="loopPeriode" name="periode[]" />
                                </center>
                            </td>
                            <td><center><b><span id="jumlah_<?php echo $n; ?>"></span></b><input type="hidden" name="nilai_kriteria[]" id="nilai_<?php echo $n ?>" /></center></td>
                        </tr>
                    <?php 
                    $n++;
                    } ?>
                </tbody>
            </table>
            <button class="btn btn-primary float-right mt-3" id="simpan" type="submit">Simpan Data</button>
            <?php echo form_close(); ?>
            <!-- .//table -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#ta').change(function(e){
            e.preventDefault();

            var v = $(this).val();
            var t = $('#ta option:selected').html();
            console.log(t)
            $('.loopTahun').val(v);
            $('.loopPeriode').val(t);
        });

        $('#gur').change(function(e){
            e.preventDefault();

            var a = $(this).val();
            $('.loopGuru').val(a);
        });
        
        $('.sub_1').keyup(function(){
            var total = 0;
            var jumlah = $('.sub_1').length;
            $('.sub_1').each(function(){
                total += +$(this).val();
            })
            var hasil = total / jumlah;
            $('#jumlah_1').html(hasil);
            $('#nilai_1').val(hasil);
        })

        $('.sub_2').keyup(function(){
            var total = 0;
            var jumlah = $('.sub_2').length;
            $('.sub_2').each(function(){
                total += +$(this).val();
            })
            var hasil = total / jumlah;
            $('#jumlah_2').html(hasil);
            $('#nilai_2').val(hasil);
        })

        $('.sub_3').keyup(function(){
            var total = 0;
            var jumlah = $('.sub_3').length;
            $('.sub_3').each(function(){
                total += +$(this).val();
            })
            var hasil = total / jumlah;
            $('#jumlah_3').html(hasil);
            $('#nilai_3').val(hasil);
        });

        $('.sub_4').keyup(function(){
            var total = 0;
            var jumlah = $('.sub_4').length;
            $('.sub_4').each(function(){
                total += +$(this).val();
            })
            var hasil = total / jumlah;
            $('#jumlah_4').html(hasil);
            $('#nilai_4').val(hasil);
        });

        $('.sub_5').keyup(function(){
            var total = 0;
            var jumlah = $('.sub_5').length;
            $('.sub_5').each(function(){
                total += +$(this).val();
            })
            var hasil = total / jumlah;
            $('#jumlah_5').html(hasil);
            $('#nilai_5').val(hasil);
        });
    });

    $(document).ready(function(){
        $('#formNilai').submit(function(e){
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
                    var periode = $('#ta').val();
                    setTimeout(function(){
                        if(data.status === 'success'){
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Lanjut Input Nilai</button><a href="<?php echo base_url(); ?>analisa/normalisasi/'+ periode  +'" class="btn btn-primary">Lanjut Perhitungan Normalisasi</a>');
                            $('#ModalGue').modal('show');
                            $('input[type="number"]').val('');
                            $('select[name="gur"]').val('');
                            $('#jumlah_1').html('');
                            $('#jumlah_2').html('');
                            $('#jumlah_3').html('');
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

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>