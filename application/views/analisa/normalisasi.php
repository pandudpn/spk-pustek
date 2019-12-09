<?php 
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Normalisasi</h3>
            <div class="col-md-12 text-center mt-4">
                <h6>Sebelum Normalisasi</h6>
            </div>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle">
                            <center>Alternatif</center>
                        </th>
                        <th colspan="4">
                            <center>Kriteria</center>
                        </th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria AS $data){ ?>
                        <th>
                            <center><?php echo $data->nama_kriteria ?> <small>(<?php echo $data->cb ?>)</small></center>
                        </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($evaluasi AS $data){ ?>
                    <tr>
                        <td>
                            <center><?php echo $data->nama ?></center>
                        </td>
                        <td>
                            <center><?php echo $data->k1 ?></center>
                        </td>
                        <td>
                            <center><?php echo $data->k2 ?></center>
                        </td>
                        <td>
                            <center><?php echo $data->k3 ?></center>
                        </td>
                        <td>
                            <center><?php echo $data->k4 ?></center>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <center>Bobot</center>
                        </th>
                        <?php foreach($kriteria AS $data){ ?>
                        <th>
                            <center><?php echo $data->bobot ?></center>
                        </th>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>
            <div class="col-md-12 text-center mt-5">
                <h6>Normalisasi</h6>
            </div>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle">
                            <center>Alternatif</center>
                        </th>
                        <th colspan="4">
                            <center>Kriteria</center>
                        </th>
                    </tr>
                    <tr>
                        <?php foreach($kriteria AS $data){ ?>
                        <th>
                            <center><?php echo $data->nama_kriteria ?></center>
                        </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $k1 = array();
                    $k2 = array();
                    $k3 = array();
                    $k4 = array();
                    foreach($maxmin AS $data){ 
                        foreach($evaluasi AS $result => $val){
                            if($val->k1){
                                if($val->cb_1 == 'cost'){
                                    $k1[] = round($data->nilai_k1 / $val->k1, 4);
                                }elseif($val->cb_1 == 'benefit'){
                                    $k1[] = round($val->k1 / $data->nilai_k1, 4);
                                }
                            }
                            if($val->k2){
                                if($val->cb_2 == 'cost'){
                                    $k2[] = round($data->nilai_k2 / $val->k2, 4);
                                }elseif($val->cb_2 == 'benefit'){
                                    $k2[] = round($val->k2 / $data->nilai_k2, 4);
                                }
                            }
                            if($val->k3){
                                if($val->cb_3 == 'cost'){
                                    $k3[] = round($data->nilai_k3 / $val->k3, 4);
                                }elseif($val->cb_3 == 'benefit'){
                                    $k3[] = round($val->k3 / $data->nilai_k3, 4);
                                }
                            }
                            if($val->k4){
                                if($val->cb_4 == 'cost'){
                                    $k4[] = round($data->nilai_k4 / $val->k4, 4);
                                }elseif($val->cb_4 == 'benefit'){
                                    $k4[] = round($val->k4 / $data->nilai_k4, 4);
                                }
                            } ?>
                            <tr>
                                <td>
                                    <center><?php echo $val->nama ?></center>
                                </td>
                                <td>
                                    <center><?php echo $k1[$result] ?></center>
                                </td>
                                <td>
                                    <center><?php echo $k2[$result] ?></center>
                                </td>
                                <td>
                                    <center><?php echo $k3[$result] ?></center>
                                </td>
                                <td>
                                    <center><?php echo $k4[$result] ?></center>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
            <div class="col-md-12 text-center mt-5">
                <h6 class="mt-3">Perhitungan</h6>
            </div>
            <?php echo form_open('analisa/normalisasi/'.$periode, array('id' => 'Normalisasi')); ?>
            <div class="row">
                <?php 
                foreach($evaluasi AS $key => $data){
                    $total  = round(($k1[$key] * $data->bobot_1) + ($k2[$key] * $data->bobot_2) + ($k3[$key] * $data->bobot_3) + ($k4[$key] * $data->bobot_4), 4);
                ?>
                <div class="col-md-3">
                    <p>
                        <b><?php echo $data->nama ?></b>
                        <input type="hidden" name="guru[]" value="<?= $data->kode_guru ?>" />
                        <input type="hidden" name="nilai_akhir[]" value="<?= $total ?>" />
                    </p>
                </div>
                <div class="col-md-1">
                    <p>=></p>
                </div>
                <div class="col-md-6">
                    <p><?php echo "(".$k1[$key]." * ".$data->bobot_1.") + (".$k2[$key]." * ".$data->bobot_2.") + (".$k3[$key]." * ".$data->bobot_3.") + (".$k4[$key]." * ".$data->bobot_4.")"; ?></p>
                </div>
                <div class="col-md-1">
                    <p>=</p>
                </div>
                <div class="col-md-1">
                    <p><b><?php echo $total ?></b></p>
                </div>
                <?php } ?>
            </div>
            <button class="btn btn-primary float-right mt-3" type="submit" id="simpan">Simpan</button>
            <?php echo form_close(); ?>    
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#Normalisasi').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    $('#simpan').html('<i class="mdi mdi-loading mdi-spin"></i>');
                    $('#simpan').addClass('disabled');
                },
                success: function(json){
                    setTimeout(() => {
                        if(json.status === 'success'){
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(json.pesan);
                            $('#ModalFooter').html('<a href="<?php echo base_url(); ?>analisa/pilih" class="btn btn-primary">Lanjut Pemilihan</a>');
                            $('#ModalGue').modal('show');
                        }
                        $('#simpan').removeClass('disabled');
                        $('#simpan').html('Simpan');
                    }, 1000)
                },
                error: function(a, b, c){
                    console.log(a);
                    console.log(b);
                    console.log(c);
                }
            })
        })
    })
</script>

<?php 
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>