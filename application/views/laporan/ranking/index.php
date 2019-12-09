<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Laporan Perankingan</h4>
            <!-- form pencarian -->
            <?= form_open('laporan/ranking', array('id' => 'formRanking')); ?>
            <div class="row mt-2">
                <div class="col-md-4 offset-md-3 col-12">
                    <div class="form-group row">
                        <label for="tahunajaran" class="col-form-label col-md-5">Tahun Ajaran</label>
                        <div class="col-md-7">
                            <select name="tahunajaran" id="tahunajaran" class="form-control">
                                <option value="" selected disabled>-</option>
                                <?php foreach($periode AS $data){ ?>
                                <option value="<?= $data->id_periode; ?>"><?php echo $data->nama_periode ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit" id="cari"><i class="mdi mdi-magnify"></i> Cari Data</button>
                </div>
            </div>
            <?= form_close(); ?>
            <!-- .// form pencarian -->
            <div id="result" class="mt-4"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#formRanking').submit(function(e){
            e.preventDefault();
            var tahun = $('#tahunajaran').val();
            $.ajax({
                type: 'POST',
                beforeSend: function(){
                    $('#cari').html('<i class="mdi mdi-spin mdi-loading"> Mencari data......</i>');
                    $('#cari').addClass('disabled');
                    $('#result').html('<h1 class="text-center text-gray"><i class="mdi mdi-loading mdi-spin"> Mencari data......</i></h1>');
                },
                success: function(){
                    setTimeout(function(){
                        var URL = "<?php echo base_url(); ?>laporan/detailRanking/"+tahun;

                        $('#result').load(URL);
                        $('#cari').html('<i class="mdi mdi-magnify"></i> Cari Data');
                        $('#cari').removeClass('disabled');
                    }, 2000);
                }
            })
        })
    });
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>