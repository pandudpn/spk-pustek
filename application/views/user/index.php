<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data User</h4>
            <table class="table table-bordered table-hover" id="tableUser">
                <thead>
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Action</center></th>
                        <th><center>Nama</center></th>
                        <th><center>Username</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php 
$tambahan = '';
$tambahan .= "<a href='".site_url('user/tambah')."' style='margin-left:10px' class='btn btn-info' id='TambahUser'><i class='mdi mdi-plus'></i> Tambah</a>";
$tambahan .= "<span id='Notifikasi' style='display: none;margin-left:10px;'></span>";
?>
<script>
    $(document).ready(function() {
		var dataTable = $('#tableUser').DataTable({
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
				url :"<?php echo site_url('user/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#tableUser").append('<tbody><tr><th colspan="5"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});

	$(document).on('click', '#HapusUser', function(e){
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
                    $('#tableUser').DataTable().ajax.reload( null, false );
                }, 2000)
			}
		});
	});

	$(document).on('click', '#EditUser', function(e){
		e.preventDefault();
		
		$('#ModalHeader').html('Edit User');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

    $(document).on('click', '#TambahUser', function(e){
		e.preventDefault();
		
		$('#ModalHeader').html('Tambah User');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

    $(document).on('keyup', '#username', function(e){
        e.preventDefault();

        var username = $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>user/ajax_username',
            type: 'POST',
            data: 'username='+username,
            dataType: 'json',
            cache: false,
            success: function(data){
                if(data.status == 0){
                    $('#cek_username').html(data.pesan);
                    $('#Yes').addClass('disabled');
                }else if(data.status == 1){
                    $('#cek_username').html('');
                    $('#Yes').removeClass('disabled');
                }
            }
        });
    })
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>