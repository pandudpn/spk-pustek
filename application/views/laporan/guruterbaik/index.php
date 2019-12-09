<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Laporan Guru Terbaik</h4>
            <table class="table" id="tableGuru">
                <thead>
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama Guru</center></th>
                        <th><center>Nilai Akhir</center></th>
                        <th><center>Tahun Ajaran</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php
$tambahan = '';
$tambahan .= "<a href='".site_url('laporan/cetakGuruTerbaik/')."' style='margin-left:10px' class='btn btn-primary' target='_blank'><i class='mdi mdi-printer'></i> Print</a>";
?>
<script>
    $(document).ready(function(){
        var dataTable = $('#tableGuru').DataTable({
			serverSide: true,
			stateSave : false,
			bAutoWidth: true,
			oLanguage: {
				sSearch: "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				sLengthMenu: "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
				sInfo: "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				sInfoFiltered: "(difilter dari _MAX_ total data)", 
				sZeroRecords: "Pencarian tidak ditemukan", 
				sEmptyTable: "Belum ada data di dalam Database!", 
				sLoadingRecords: "Harap Tunggu...", 
				oPaginate: {
					sPrevious: "Prev",
					sNext: "Next"
				}
			},
			columnDefs: [ 
				{
					targets: 'no-sort',
					orderable: false,
				}
	        ],
			sPaginationType: "simple_numbers", 
			iDisplayLength: 10,
			aLengthMenu: [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			ajax:{
				url :"<?php echo site_url('laporan/showAllGuruTerbaik'); ?>",
				type: "post",
				error: function(){ 
					$("#tableGuru").append('<tbody><tr><th colspan="3"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
    });
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>