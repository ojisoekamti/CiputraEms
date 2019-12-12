<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- select2 -->
<link href="<?= base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/select2/dist/js/select2.min.js"></script>
<!-- flat -->
<link href="<?= base_url() ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">

<!DOCTYPE html>
<div id="modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Detail Log</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped jambo_table bulk_action">
					<thead>
						<tr>
							<th>Point Detail</th>
							<th>Before</th>
							<th>After</th>
						</tr>
					</thead>
					<tbody id="dataModal">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>
<div style="float:right">
    <h2>
        <button class="btn btn-warning" onClick="window.location.href = '<?= substr(current_url(), 0, strrpos(current_url(), "/")) ?>'">
            <i class="fa fa-arrow-left"></i>
            Back
        </button>
        <button class="btn btn-success" onClick="window.location.reload()">
            <i class="fa fa-repeat"></i>
            Refresh
        </button>
    </h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
    <br>
    <form id="form" class="form-horizontal form-label-left">
        <div class="col-md-6 col-xs-12">
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis LOI</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="jenis" required="" name="jenis_loi_id" disabled class="form-control select2">
                            <option value="">--Pilih Jenis--</option>
                            <?php foreach($dataJenis as $v){?>
								<option value="<?=$v['id']?>"<?=($dataSelect->jenis == $v['id'])?"selected":""?>><?=$v['nama']?></option>
							<?php }?>
                        </select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Paket</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="kode" disabled required name="kode" value="<?=$dataSelect->kode?>" placeholder="Masukkan Kode Jenis">
					</div>
                </div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Paket</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="nama" disabled required name="nama" value="<?=$dataSelect->nama?>" placeholder="Masukkan Nama Jenis">
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Biaya Registrasi (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" id="biaya_admin" disabled value="<?=number_format($dataSelect->biaya_registrasi)?>" required name="biaya_admin" placeholder="Masukkan Biaya Pasang Baru">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Jasa Pengurusan (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" id="harga_jenis" disabled value="<?=number_format($dataSelect->harga_jasa)?>" required name="harga_jenis" placeholder="Masukkan Harga Jual">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Prakiraan Biaya (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" id="biaya_resmi" class="form-control currency" disabled value="<?=number_format($dataSelect->biaya_prakiraan)?>" required name="biaya_resmi" placeholder="Masukkan Biaya Registrasi">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="form-control" rows="3" id="keterangan" name="keterangan" disabled placeholder='Masukkan Keterangan'><?=$dataSelect->keterangan?></textarea>
					</div>
				</div>
            </div>
            <div class="clearfix"></div>
			<hr>
			<div class="col-md-12 col-xs-12">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th class="col-md-2">Item</th>
							<th class="col-md-1">Volume</th>
							<th class="col-md-2">Satuan</th>
							<th class="col-md-2">Harga Satuan</th>
							<th class="col-md-3">Status Item</th>
							<th class="col-md-2">Total</th>
							<th>Hapus</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><center>TOTAL</center></td>
							<td><input name="hrg_prediksi" id="hrg_prediksi" disabled required="" class="form-control col-md-1 col-xs-12 currency"></td>
						</tr>             
						<?php foreach($dataPaketSelect as $v){?>
						<tr>
							<td>
								<select class="nama_item form-control col-md-1 col-xs-12 select2" value="0" id="nama_item-1" name="nama_item[]">
									<option value="">Pilih Item</option>
									<?php foreach($dataItem as $b){?>
										<option value="<?=$b['id']?>"<?=($v->item == $b['id'])?"selected":""?>><?=$b['nama']?></option>
									<?php }?>
								</select>
							</td>
							<td>
								<input id="volume" name="volume[]" required="" value="<?=$v->volume?>" class="volume form-control col-md-1 col-xs-12 currency">
							</td>
							<td>
								<input id="satuan-1" name="satuan[]" readonly required="" value="<?=$v->satuan?>" class="satuan form-control col-md-1 col-xs-12">
							</td>
							<td>
								<input id="harga_satuan-1" name="harga_satuan[]" readonly required="" value="<?=number_format($v->harga_satuan)?>" class="harga_satuan form-control col-md-1 col-xs-12">
							</td>
							<td>
								<input id="status_item-1" name="status_item[]" readonly value="<?=$v->status_item?>" required="" class="status_item form-control col-md-1 col-xs-12">
							</td>    
							<td>
								<input id="total-1" name="total[]" readonly required="" value="" class="form-control col-md-1 col-xs-12 currency">
							</td>
							<td>
							<a class='delete btn btn-danger' href='#'><i class='fa fa-trash'></i> </a>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<button type="button" id='btn-add-paket' class="btn btn-danger pull-right" ><i class="fa fa-plus"></i> Add Item</button>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<input id="btn-update" class="btn btn-success col-md-1 col-md-offset-5" value="Edit">
					<input id="btn-cancel" class="btn btn-danger col-md-1" value="Cancel" style="display:none">
				</div>
			</div>
    </form>
</div>
<div class="x_panel">
	<div class="x_title">
		<h2>Log</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		<table class="table table-striped jambo_table bulk_action tableDT">
			<thead>
				<tr>
					<th>No</th>
					<th>Waktu</th>
					<th>User</th>
					<th>Status</th>
					<th>Detail</th>
				</tr>
			</thead>
			<tbody>
				<?php
            $i = 0;
            foreach ($data as $key => $v) {
                ++$i;
                echo '<tr>';
                echo "<td>$i</td>";
                echo "<td>$v[date]</td>";
                echo "<td>$v[name]</td>";
                echo '<td>';
                if ($v['status'] == 1) {
                    echo 'Tambah';
                } elseif ($v['status'] == 2) {
                    echo 'Edit';
                } else {
                    echo 'Hapus';
                }
                echo '</td>';
                echo "
                    <td class='col-md-1'>
                        <a class='btn-modal btn btn-sm btn-primary col-md-12' data-toggle='modal' data-target='#modal' data-transfer='$v[id]' data-type='$v[status]'>
                            <i class='fa fa-pencil'></i>
                        </a>
                    </td>
                ";
                echo '</td></tr>';
            }
        ?>
			</tbody>
		</table>
	</div>
</div>


    <script>
		// var komponen = $(".isi")[0].outerHTML;
        function notif(title, text, type) {
			new PNotify({
				title: title,
				text: text,
				type: type,
				styling: 'bootstrap3'
			});
		}
        $(function() {

            $('.select2').select2();

            $("#submit").click(function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    data: $("#form").serialize(),
                    url: "<?= site_url() ?>/P_master_paket_loi/ajax_save",
                    dataType: "json",
                    success: function(data) {
						location.reload();
                        if (data.status)
                            notif('Sukses', data.message, 'success');
                        else
                            notif('Gagal', data.message, 'danger');
                    }
                });
            });
        });
	$("#btn-add-paket").click(function(){
		// $("#tbody").append(komponen);
		// var jenis = $("#jenis").val();
		// $.ajax({
		// 	type: "POST",
		// 	data: {
		// 		jenis: jenis
		// 	},
		// 	url: "<?= site_url() ?>/P_master_paket_loi/ajax_item",
		// 	dataType: "json",
		// 	success: function(data) {
		// 		var str = "<tr>"+
		//             "<td hidden><input name='id_range_air_detail[]' value='0'></td>" +
		// 			"<td class='no'>"+
		// 				"<select name='nama_item' class='form-control select2'>"+
		// 					$.each()
		// 					"<option value='"data.id"'>"+data.nama+"</option>"+
		// 				"</select>"+
		// 			"</td>" +
		// 			"<td class='nolog' ></td>" +
		// 			"<td><input type='text' class='form-control currency'  name='range_awal[]' value='' placeholder='' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' /></td>" +
        //             "<td><input type='text' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' name='range_akhir[]' value='0' class='form-control currency'/></td>" +
		// 			"<td><input type='text' class='form-control currency' value='0' name='harga_hpp[]' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'  /></td>" +
		// 			"<td><input type='text' class='form-control currency' value='0' name='harga_range[]' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'  /></td>" +
        //         "</tr>";
        // 		$("#tbody").append(str);
		// 	}
		// });

		var str = "<tr>"+
			"<td hidden><input name='id_range_air_detail[]' value='0'></td>" +
			"<td>"+
				"<select name='nama_item' class='form-control select2'>"+
					"<option value=''></option>"+
				"</select>"+
			"</td>" +
			"<td><input type='text' class='form-control'/></td>" +
			"<td><input type='text' class='form-control currency'  name='range_awal[]' value='' placeholder='' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' /></td>" +
			"<td><input type='text' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' name='range_akhir[]' value='0' class='form-control currency'/></td>" +
			"<td><input type='text' class='form-control currency' value='0' name='harga_hpp[]' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'  /></td>" +
			"<td><input type='text' class='form-control currency' value='0' name='harga_range[]' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'  /></td>" +
			"<td><a class='delete btn btn-danger'><i class='fa fa-trash'></i></a></td>" +
		"</tr>";
		$("#tbody").append(str);
		
    });
	$("#jenis").change(function(){
		url = '<?=site_url(); ?>/P_master_paket_loi/ajax_get_item';
		$.ajax({
			type: "post",
			url: url,
			data: {
				jenis : $("#jenis").val()
			},
			dataType: "json",
			success: function (data) {
				console.log(data);
				$("#nama_item-1")[0].innerHTML = "";
				$("#nama_item-1").append("<option value=''>Pilih Item</option>");
				$.each(data, function (key, val) {
					$("#nama_item-1").append("<option satuan='"+val.satuan+"' harga_satuan='"+val.harga_satuan+"' status_item='"+val.status_item+"'  value='" + val.id + "'    >" + val.nama + "</option>");
				});
			}
		});
	});

	$("#btn-update").click(function () {
		$("#jenis").removeAttr("disabled");
		$("#kode").removeAttr("disabled");
		$("#nama").removeAttr("disabled");
		$("#biaya_admin").removeAttr("disabled");
		$("#harga_jenis").removeAttr("disabled");
		$("#biaya_resmi").removeAttr("disabled");
		$("#keterangan").removeAttr("disabled");
		$("#btn-cancel").removeAttr("style");
		$("#btn-update").val("Update");
		$("#btn-update").attr("type", "submit");
	});

	$("#btn-cancel").click(function () {
		$("#jenis").attr("disabled", "")
		$("#kode").attr("disabled", "")
		$("#nama").attr("disabled", "")
		$("#biaya_admin").attr("disabled", "")
		$("#harga_jenis").attr("disabled", "")
		$("#biaya_resmi").attr("disabled", "")
		$("#keterangan").attr("disabled", "")
		$("#btn-cancel").attr("style", "display:none");
		$("#btn-update").val("Edit")
		$("#btn-update").removeAttr("type");
	});

	$(".nama_item").change(function(){
		var satuan = $("option:selected",$(this)).attr("satuan");
		var status_item = $("option:selected",$(this)).attr("status_item");
		if(status_item == '1'){
			status = 'Dipinjamkan';
		}else{
			status = 'Hak Milik';
		}
		var hrg_satuan = $("option:selected",$(this)).attr("harga_satuan");
		$(this).parent().parent().children().eq(2).children().val(satuan);
		$(this).parent().parent().children().eq(3).children().val(formatNumber(hrg_satuan));
		$(this).parent().parent().children().eq(4).children().val(status);
	});

	$("body").on("keyup",".volume",function(){
		console.log($(this).val());
		console.log($(this).parent().parent().children().eq(3).children().val());
		console.log($(this));
		$(this).val(formatNumber($(this).val()));
		$(this).parent().parent().children().eq(5).children().val(
			formatNumber(
				unformatNumber($(this).val()) * 
				unformatNumber($(this).parent().parent().children().eq(3).children().val())
			)
		);
		var total = 0;
		for(i = 0 ; i < $(".isi").length ; i++){
			total += parseInt(unformatNumber($(".isi").eq(i).children().eq(5).children().val()));
		}
		$("#hrg_prediksi").val(formatNumber(total));
	});

	function formatNumber(data) {
		data = data + '';
		data = data.replace(/,/g, "");

		data = parseInt(data) ? parseInt(data) : 0;
		data = data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		return data;
	}
	function unformatNumber(data) {
		data = data + '';
		return data.replace(/,/g, "");
	}

	$("body").on("click",".delete",function(){
		$(this).parent().parent().remove();
	});
</script>