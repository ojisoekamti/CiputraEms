<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- select2 -->
<link href="<?= base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/select2/dist/js/select2.min.js"></script>
<script src="<?= base_url() ?>vendors/switchery/dist/switchery.min.js"></script>
<!-- flat -->
<link href="<?= base_url() ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">

<!DOCTYPE html>
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
                        <select id="jenis" required="" name="jenis_loi_id" class="form-control select2">
                            <option value="">--Pilih Jenis--</option>
                            <?php foreach($dataJenis as $v){?>
                                <option value="<?=$v['id']?>"><?=$v['nama']?></option>
                            <?php }?>
                        </select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Paket</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="kode" disabled required name="kode" placeholder="Masukkan Kode Jenis">
					</div>
                </div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Paket</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" id="nama" disabled required name="nama" placeholder="Masukkan Nama Jenis">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-12 col-xs-12">Minimum Deposit</label>
					<div class="col-md-3 col-sm-12 col-xs-2">
						<div class="checkbox">
							<label>
								<p style="display:contents">Unuse</p>
								<input id="deposit_flag" type="checkbox" name="deposit_flag" class="js-switch" value="1" checked />
								<p style="display:contents">Use</p>
							</label>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-9">
						<input type="text" class="form-control currency" value="0" id="deposit_min" required name="deposit_min" placeholder="Masukkan Minimum Deposit">
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Biaya Registrasi (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" value="0" id="biaya_registrasi" disabled required name="biaya_registrasi" placeholder="Masukkan Biaya Registrasi">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Jasa Pengurusan (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" value="0" id="harga_jasa" disabled required name="harga_jasa" placeholder="Masukkan Harga Jasa">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Prakiraan Biaya (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" value="0" id="biaya_prakiraan" class="form-control currency" disabled required name="biaya_prakiraan" placeholder="Masukkan Prakiraan Biaya">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="form-control" rows="3" id="keterangan" name="keterangan" disabled placeholder='Masukkan Keterangan'></textarea>
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
						<tr class="isi">
							<td>
								<select class="nama_item form-control col-md-1 col-xs-12 select2" value="0" id="nama_item-1" name="nama_item[]">
									<option value="">Pilih Item</option>
								</select>
							</td>
							<td>
								<input id="volume" name="volume[]" required="" value="" class="volume form-control col-md-1 col-xs-12 currency">
							</td>
							<td>
								<input id="satuan-1" name="satuan[]" readonly required="" class="satuan form-control col-md-1 col-xs-12">
							</td>
							<td>
								<input id="harga_satuan-1" name="harga_satuan[]" readonly required="" class="harga_satuan form-control col-md-1 col-xs-12">
							</td>
							<td>
								<input id="status_item-1" name="status_item[]" readonly required="" class="status_item form-control col-md-1 col-xs-12">
							</td>    
							<td>
								<input id="total-1" name="total[]" readonly required="" value="" class="form-control col-md-1 col-xs-12 currency">
							</td>
							<td>
							<a class='delete btn btn-danger' href='#'><i class='fa fa-trash'></i> </a>
							</td>
						</tr>              
					</tbody>
				</table>
				<button type="button" id='btn-add-paket' class="btn btn-danger pull-right" ><i class="fa fa-plus"></i> Add Item</button>
			</div>
		<div class="form-group">
			<div class="center-margin">
				<button class="btn btn-primary" type="reset">Reset</button>
				<button type="submit" id="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
	</form>


    <script>
		var komponen = $(".isi")[0].outerHTML;
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
		
	$("#deposit_flag").change(function(){
		if($("#deposit_flag").is(':checked')){
			$("#deposit_min").attr('disabled',false);
		}else{
			$("#deposit_min").attr('disabled','disabled');
		}
	})

	$("#btn-add-paket").click(function(){
		$("#tbody").append(komponen);
	});
	
	$("#jenis").change(function(){
		$("#kode").removeAttr("disabled");
		$("#nama").removeAttr("disabled");
		$("#biaya_registrasi").removeAttr("disabled");
		$("#harga_jasa").removeAttr("disabled");
		$("#biaya_prakiraan").removeAttr("disabled");
		$("#keterangan").removeAttr("disabled");
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
		var hrg_prediksi = $("#hrg_prediksi").val();
		$("#biaya_prakiraan").val(hrg_prediksi);
	});
	$("body").on("click",".delete",function(){
		$(this).parent().parent().remove();
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
    </script>