<?php if($detail->num_rows() > 0){ ?>
    <table class="table table-bordered" id="tableLaporan">
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle;"><center>Nama</center></th>
                <th colspan="4"><center>Kriteria</center></th>
                <th rowspan="2" style="vertical-align: middle;"><center>Nilai Akhir</center></th>
            </tr>
            <tr>
                <?php foreach($kriteria AS $k){ ?>
                <th><center><?= $k->nama_kriteria; ?></center></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($detail->result() AS $row){ ?>
            <tr>
                <td><center><?= $row->nama; ?></center></td>
                <td><center><?= number_format($row->k1, 4, ',','.'); ?></center></td>
                <td><center><?= number_format($row->k2, 4, ',','.'); ?></center></td>
                <td><center><?= number_format($row->k3, 4, ',','.'); ?></center></td>
                <td><center><?= number_format($row->k4, 4, ',','.'); ?></center></td>
                <td><center><?= number_format($row->nilai_akhir, 4, ',','.'); ?></center></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function(){
            var tahun = '<?php echo $tahun; ?>';
            $('#tableLaporan').DataTable({
                oLanguage: {
                    sLengthMenu: '_MENU_ Data Per Halaman <a href="<?php echo base_url(); ?>laporan/cetakkinerjaguru/'+tahun+'" target="_blank" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>'
                }
            });
        })
    </script>
<?php }else{ ?>
    <h2 class="text-center text-danger">Tidak ada Data.</h2>
<?php } ?>