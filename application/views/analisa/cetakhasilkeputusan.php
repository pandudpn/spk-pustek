<?php 
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view("templates/sidebar"); ?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Cetak Hasil Keputusan Terbaik</h3>
            <div class="row">
                <div class="col-md-4 offset-md-3">
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
                    <button class="btn btn-primary" id="cari"><i class="mdi mdi-magnify"></i> Cari</button>
                </div>
            </div>
            <br><br>
            <div id="result"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#cari').click(function(e){
            e.preventDefault();

            var tahunajaran = $('#tahunajaran').val();

            $.ajax({
                url: "<?php echo base_url('analisa/cetakhasilkeputusan'); ?>",
                type: "GET",
                data: {'tahunajaran':tahunajaran},
                cache: false,
                dataType: 'JSON',
                beforeSend: function(){
                    $('#cari').html('<i class="mdi mdi-loading mdi-spin"></i>');
                    $("#cari").addClass('disabled');
                },
                success: function(data){
                    setTimeout(() => {
                        $('#cari').html('<i class="mdi mdi-magnify"></i> Cari');
                        $('#cari').removeClass('disabled');
                        if(data == null){
                        var html = '<div class="col-md-12 text-center"><h3 class="text-danger"><i>Data yang anda cari belum tersedia. Silahkan pilih tahun ajaran yang lain.</i></h3></div>';
                        }else{
                        var html = "<a href='<?php echo base_url(); ?>analisa/cetakguruterbaik/"+data.tahun_ajaran+"' class='btn btn-primary float-right' target='_blank'><i class='mdi mdi-printer'></i> Print</a>";
                            html += '<div class="row">';
                            html += '<div class="col-md-2 text-right">';
                            html += '<img src="<?php echo base_url(); ?>assets/images/logo.png" style="width:120px; height: 120px;" />';
                            html += '</div>';
                            html += '<div class="col-md-10">';
                            html += '<div class="row">';
                            html += '<div class="col-12 text-center">';
                            html += '<h4>YAYASAN PENGEMBANGAN SAIN DAN TEKNOLOGI PUSTEK</h4>';
                            html += '</div>';
                            html += '<div class="col-12 text-center">';
                            html += '<p style="font-size:18px;" class="text-primary">SEKOLAH MENENGAH KEJURUAN</p>';
                            html += '</div>';
                            html += '<div class="col-12 text-center">';
                            html += '<p style="font-size:18px;" class="text-primary"><b>SMK PUSTEK SERPONG</b></p>';
                            html += '</div></div></div></div>';
                            html += '<div class="col-12 text-center">';
                            html += '<p>Paket keahlian : Teknik Permesinan, Teknik Kendaraan Ringan, Teknik Sepeda Motor,</p>';
                            html += '<p>Teknik Komputer Jaringan, Multimedia, Akuntansi, Administrasi Perkantoran</p>';
                            html += '<p style="font-size:18px;" class="text-danger">TERAKREDITASI. A</p>';
                            html += '<small>Jl. Raya Serpong No. 17 Priyang Kelurahan Pondok Jagung (Samping WTC Matahari) Serpong Utara</small><br />';
                            html += '<small>Kota Tangerang Selatan Provinsi Banten Telp/Fax 021 5388243 Website : <a href="http://smk.pustekserpong.com" target="_blank">http://smk.pustekserpong.com</a></small>';
                            html += '</div>';
                            html += '<hr />';
                            html += '<h4 class="text-center">LAPORAN HASIL PEMILIHAN GURU TERBAIK</h4>';
                            html += '<p>Berdasarkan kebijakan SMK Pustek Serpong, hasil seleksi guru terbaik pada tahun ' + data.nama_periode + ' adalah : </p>'
                            html += '<div class="row">'
                            html += '<div class="col-md-4">Nama Guru</div>'
                            html += '<div class="col-md-1">:</div>'
                            html += '<div class="col-md-7">' + data.nama_guru + '</div>'
                            html += '<div class="col-md-4">Kode Guru</div>'
                            html += '<div class="col-md-1">:</div>'
                            html += '<div class="col-md-7">' + data.kode_guru + '</div>'
                            html += '<div class="col-md-4">Jenis Guru</div>'
                            html += '<div class="col-md-1">:</div>'
                            html += '<div class="col-md-7">' + data.jenis + '</div>'
                            html += '<div class="col-md-4">Nama Sekolah</div>'
                            html += '<div class="col-md-1">:</div>'
                            html += '<div class="col-md-7">SMK Pustek Serpong</div>'
                            html += '<div class="col-md-4">Periode Penilaian</div>'
                            html += '<div class="col-md-1">:</div>'
                            html += '<div class="col-md-7">' + data.nama_periode + '</div>'
                            html += '</div>'
                            html += '<p class="mt-3">Demikian surat ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>'
                            html += '<p class="text-right">Kepala Sekolah</p>'
                            html += '<p class="text-right mt-5"><b>Dr. H. Mahthodah, S., M.Si</b></p>'
                            html += '<p class="text-right">NIP. 19600801 198411 1 001</p>'
                        }

                        $('#result').html(html);
                    }, 1000)
                }
            })
        });
    });
</script>

<?php 
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2'); ?>