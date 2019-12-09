<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Sub Kriteria</h4>
            <table class="table table-bordered table-hover" id="subkriteria">
                <thead>
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama</center></th>
                        <th><center>Nama</center></th>
                        <th><center>Action</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php 
$tambahan = '';
$tambahan .= "<a href='".site_url('subkriteria/tambah')."' style='margin-left:10px' class='btn btn-info' id='TambahKriteria'><i class='mdi mdi-plus'></i> Tambah</a>";
$tambahan .= "<span id='Notifikasi' style='display: none;margin-left:10px;'></span>";
?>
<script>
    $(document).ready(function() {
        var groupColumn = 1;
		var dataTable = $('#subkriteria').DataTable({
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
					visible: false,
					targets: groupColumn
				}
	        ],
			sPaginationType: "simple_numbers", 
			iDisplayLength: 10,
            aLengthMenu: [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
            drawCallback: function ( settings ) {
	        	var api = this.api();
				var rows = api.rows( {page:'current'} ).nodes();
				var last=null;
	
				api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
						$(rows).eq( i ).before(
							'<tr class="group"><td colspan="3">'+group+'</td></tr>'
						);
	
						last = group;
					}
				} );
	        },
			ajax:{
				url :"<?php echo site_url('subkriteria/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#subkriteria").append('<tbody><tr><th colspan="4"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});

	$(document).on('click', '#Hapus', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus ini?');
		$('#ModalFooter').html("<button type='button' class='btn btn-danger' data-dismiss='modal'>Batal</button><button type='button' class='btn btn-primary' id='YesDelete' data-url='"+Link+"'>Ya, saya yakin</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDelete', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			dataType:'json',
            beforeSend: function(){
                $('#Notifikasi').html('<font size="2"><i class="mdi mdi-loading mdi-spin"> Memproses....</i></font>');
                $('#Notifikasi').fadeIn('fast').show();
            },
			success: function(data){
				setTimeout(function(){
                    $('#Notifikasi').html(data.pesan);
                    $("#Notifikasi").delay(4000).fadeOut('slow');
                    $('#subkriteria').DataTable().ajax.reload( null, false );
                }, 2000)
			}
		});
	});

	$(document).on('click', '#EditKriteria', function(e){
		e.preventDefault();
		
		$('#ModalHeader').html('Edit Sub Kriteria');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

    $(document).on('click', '#TambahKriteria', function(e){
		e.preventDefault();
		
		$('#ModalHeader').html('Tambah Sub Kriteria');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>