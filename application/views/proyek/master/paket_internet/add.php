<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?=base_url(); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?=base_url(); ?>vendors/select2/dist/js/select2.min.js"></script>
<!DOCTYPE html>
<div style="float:right">
	<h2>
		<button class="btn btn-warning" onClick="window.location.href='<?=site_url(); ?>/P_master_paket_tvi'">
			<i class="fa fa-arrow-left"></i>
			Back
		</button>
		<button class="btn btn-success" onClick="window.location.href='<?=site_url(); ?>/P_master_paket_tvi/add'">
			<i class="fa fa-repeat"></i>
			Refresh
		</button>
	</h2>
</div>
<div class="clearfix"></div>
</div>
<div class="x_content">
	<br>
	<form id="form" class="form-horizontal form-label-left" method="post">
		<div class="x_content">
			<br />
			<div class="col-md-4 col-xs-12">
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Group</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name="group_tvi_id" class="form-control select2 " >
						<option selected disabled>Pilih Group Tvi</option>
							<?php
								foreach($dataGroupTvi as $key => $v){
									echo("<option value='$v[id]'>$v[name]</option>");
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Paket</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" required name="code" placeholder="Masukkan Kode Paket">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Paket</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control" required name="name" placeholder="Masukkan Nama Paket">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Bandwidth (Kbps)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" name="bandwidth" placeholder="Masukkan Kbps">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Prediksi</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" name="hrg_prediksi" id="hrg_prediksi" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Harga Hpp (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" required name="harga_hpp" placeholder="Masukkan Harga HPP">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Jual (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" id="harga" required name="harga_jual" placeholder="Masukkan Harga Jual">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Biaya Pasang Baru (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" class="form-control currency" required name="biaya_pasang_baru" placeholder="Masukkan Biaya Pasang Baru">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Biaya Registrasi (Rp)</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" value="0"  class="form-control currency" required name="biaya_registrasi" placeholder="Masukkan Biaya Registrasi">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea class="form-control" rows="3" name="description" placeholder='Masukkan Keterangan'></textarea>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-xs-12">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th class="col-md-3">Item</th>
							<th class="col-md-1">Volume</th>
							<th class="col-md-3">Satuan</th>
							<th class="col-md-2">Harga Satuan</th>
							<th class="col-md-3">Total</th>
							<th>Hapus</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<tr class="isi">
							<td>
								<select class="nama_item form-control col-md-1 col-xs-12 select2" value="0" id="nama_item" name="nama_item[]">
									<option value="">Pilih Item</option>
									<?php
									foreach($dataItemPaket as $v){
										echo ("<option satuan=".$v->satuan." harga_satuan=".$v->harga_satuan." value=" . $v->id . ">" . $v->nama . "</option>");
									}
									?>
								</select>
							</td>
							<td>
								<input id="volume" name="volume[]" required="" value="" class="volume form-control col-md-1 col-xs-12 currency">
							</td>
							<td>
								<input id="satuan" name="satuan[]" readonly required="" class="satuan form-control col-md-1 col-xs-12">
							</td>
							<td>
								<input id="harga_satuan" name="harga_satuan[]" readonly required="" class="harga_satuan form-control col-md-1 col-xs-12">
							</td>  
							<td>
								<input id="total" name="total[]" readonly required="" value="" class="form-control col-md-1 col-xs-12 currency">
							</td>
							<td>
								<a class='delete btn btn-danger' href='#' id="btn-delete-paket"><i class='fa fa-trash'></i> </a>
							</td>
						</tr>              
						<!-- <input id="idf" value="1" type="hidden" /> -->
					</tbody>
				</table>
				<button type="button" id='btn-add-paket' class="btn btn-danger pull-right" ><i class="fa fa-plus"></i> Add Paket</button>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<div class="center-margin">
						<button class="btn btn-primary" type="reset">Reset</button>
						<button type="submit" id="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
			</div>
	</form>
</div>

<!-- jQuery -->
<script>
	var komponen = $(".isi")[0].outerHTML;
	var no_paket = 1;

	function paket_item() {
		nama_item = [];
		$.each($('.nama_item'), function(key, tmp) {
			if (tmp.value != 'Pilih Item')
			nama_item.push(tmp.value);
		});

		// $(".paket-service>option").attr('disabled', false);

		$.each(nama_item, function(key, value) {
			// console.log($(".paket-service")[key].value);
			// console.log(value);
			$(".nama_item>option[value=" + value + "]").attr('disabled', true);

		});
		$.each(paket_service_id, function(key, value) {
			for (index = 0; index < $(".paket-service").length; index++) {
				if ($(".paket-service")[index].value == value) {
					$(".paket-service").eq(index).children("option[value=" + value + "]").attr('disabled', false)
					// console.log($(".paket-service")[index].value +" - "+value);
					// console.log(index +" - "+value);
					// console.log($(".paket-service"));
				}
			}
		});
		$(".select2").select2();
		// 	$.each($('.paket-service'),function(key,tmp){
		// })
	}
    $("#btn-add-paket").click(function(){
		$("#tbody").append(komponen);
		$('.select2').select2();
    });

	// $("#btn-delete-paket").click(function(){
	// 	$(".isi")[0].deleteRow(0);
	// });

	$("body").on("click",".delete",function(){
		$(this).parent().parent().remove();
	});

	$("body").on("change",".nama_item",function(){
		var satuan = $("option:selected",$(this)).attr("satuan");
		var hrg_satuan = $("option:selected",$(this)).attr("harga_satuan");
		$(this).parent().parent().children().eq(2).children().val(satuan);
		$(this).parent().parent().children().eq(3).children().val(formatNumber(hrg_satuan));
		// $(this).parent().parent().children().eq(4).children().val(4+7);
	});

	$("body").on("keyup",".volume",function(){
		console.log($(this).val());
		console.log($(this).parent().parent().children().eq(3).children().val());
		console.log($(this));
		// $(this).val(formatNumber($(this).val()));
		$(this).parent().parent().children().eq(4).children().val(
			formatNumber(
				unformatNumber($(this).val()) * 
				unformatNumber($(this).parent().parent().children().eq(3).children().val())
			)
		);
		var total = 0;
		for(i = 0 ; i < $(".isi").length ; i++){
			total += parseInt(unformatNumber($(".isi").eq(i).children().eq(4).children().val()));
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

	function notif(title, text, type) {
		new PNotify({
			title: title,
			text: text,
			type: type,
			styling: 'bootstrap3'
		});
	}
        $(function() {
			
			// $('#btn-add-paket').click(function(){
			// 	var row = "<tr>"
			// 	+"</tr>";
        	// });
            $('.select2').select2();

            $("#submit").click(function(e){
				e.preventDefault();
                $.ajax({
                    type: "POST",
                    data: $("#form").serialize(),
                    url: "<?= site_url() ?>/P_master_paket_internet/ajax_save",
                    dataType: "json",
                    success: function(data) {
						console.log(data);
                        if (data.status)
                            notif('Sukses', data.message, 'success');
                        else
                            notif('Gagal', data.message, 'danger');
                    }
                });
            });
        });
	

function hapusElemen(idf) {
    $(idf).remove();
    var idf = document.getElementById("idf").value;
    idf = idf-1;
    document.getElementById("idf").value = idf;
}
</script>