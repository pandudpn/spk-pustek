<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pemilihan Guru Terbaik</h4>
            <hr>
            <?php echo form_open('analisa/hasilkeputusan', array('id' => 'formHasil')); ?>
            <div class="row">
                <div class="col-md-4 offset-md-3 mt-4 col-12">
                    <div class="form-group row">
                        <label for="tahunajaran" class="col-form-label col-md-5">Tahun Ajaran</label>
                        <div class="col-md-7">
                            <select name="tahunajaran" id="tahunajaran" class="form-control">
                                <option value="" selected disabled>-</option>
                                <?php foreach($periode AS $data){ ?>
                                <option value="<?= $data->id_periode; ?>"><?php echo $data->nama_periode; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 mt-4 col-12">
                    <button class="btn btn-primary" id="caridata"><i class="mdi mdi-magnify"></i> Cari Data</button>
                </div>
            </div>
            <?php echo form_close(); ?>
            <div id="result" class="mt-5"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#formHasil').submit(function(e){
            e.preventDefault();

            var tahun = $('#tahunajaran').val();

            var URL = "<?php echo base_url(); ?>analisa/hasilkeputusan/"+tahun;
            $('#result').load(URL);
        })
    })
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>