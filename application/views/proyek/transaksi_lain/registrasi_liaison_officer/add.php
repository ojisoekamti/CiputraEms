<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url()?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?=base_url()?>vendors/select2/dist/js/select2.min.js"></script>


<!-- switchery -->
<link href="<?=base_url(); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?=base_url(); ?>vendors/switchery/dist/switchery.min.js"></script>
<!-- date time picker -->
<script type="text/javascript" src="<?=base_url(); ?>vendors/moment/min/moment.min.js"></script>

<link href="<?=base_url(); ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?=base_url(); ?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


<!DOCTYPE html>
<div style="float:right">
	<h2>
		<button class="btn btn-primary" onClick="window.location.href='<?=site_url()?>/transaksi_lain/p_registrasi_liaison_officer'">
			<i class="fa fa-arrow-left"></i>
			Back
		</button>
		<button class="btn btn-success" onClick="window.location.href='<?=site_url()?>/transaksi_lain/p_registrasi_liaison_officer/add'">
			<i class="fa fa-repeat"></i>
			Refresh
		</button>
	</h2>
</div>
<div class="clearfix"></div>

<div class="x_content">
	<br>
	<form id="form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="" method="post" action="<?=site_url()?>/transaksi_lain/p_registrasi_liaison_officer/save">

        <div class="col-md-6">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">LOI Jenis</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
			<select required="" class="form-control select2">
				<option value="" selected="" disabled="">--Pilih LOI Jenis--</option>
            </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="col-md-6">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipe LOI</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
			<select required="" class="form-control select2">
				<option value="" selected="" disabled="">--Pilih Tipe LOI--</option>
            </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
		<div class="col-md-6">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Unit</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
			<select required="" id="pilih_unit" name="pilih_unit" class="form-control select2">
				<option value="" selected="" disabled="">--Pilih Unit--</option>
				
				<?php
                        foreach ($dataUnit as $v) {
                            echo("<option value='$v[id]'>$v[kawasan_name] - $v[blok_name] -  $v[no_unit]</option>");
                        }
                    ?>
            </select>
            </div>
        </div>

        <div class="clear-fix"></div>
        <br>
        <br>
        <br>

		<div id="view_data">


			 <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Project</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="" readonly class="form-control"  name="project_name"  id="project_name">
  						  </div>
  						</div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kawasan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" name="kawasan_name"  id="kawasan_name" value="" readonly class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Blok</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="blok_name"  id="blok_name" value="" readonly class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Unit</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="unit"  id="unit" value="" readonly class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="customer"  id="customer" value="" readonly class="form-control">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="jenis"  id="jenis" value="" readonly class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea readonly="" class="form-control"   name="alamat"  id="alamat"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Phone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="mobile_phone"  id="mobile_phone" value="" readonly class="form-control">
                </div>
              </div>
              
            </div>
          </div>
        </div>
      <div class="clear-fix"></div>
      <hr>

        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Document</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="no_document"  id="no_document" value="" readonly class="form-control">
                </div>
              </div>

              <div class="form-group two ">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Pengajuan</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class='input-group date '>
                  <input type="text" class="form-control datetimepicker" name="tanggal_pengajuan" id="tanggal_pengajuan"
                   placeholder="Masukkan Tanggal Pengajuan"> <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
              <div class="form-group two ">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal ST </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class='input-group date '>
                  <input type="text" class="form-control datetimepicker" name="tanggal_st" id="tanggal_st"
                   placeholder="Masukkan Tanggal ST" readonly> <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
                        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <textarea  name="keterangan"  id="keterangan" required="" class="form-control"></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-6">   
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tunggakan Retribusi</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="" name="tunggakan_retribusi"  id="tunggakan_retribusi" required=""readonly class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Luas Tanah</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value=""  name="luas_tanah"  id="luas_tanah" readonly class="form-control currency">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Luas Bangunan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value=""  name="luas_bangunan"  id="luas_bangunan"readonly class="form-control currency">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarif PL</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="tarif_pl"  id="tarif_pl" readonly class="form-control currency">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Total</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="total"  id="total" readonly class="form-control currency">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Bayar</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text"  name="status_bayar"  id="status_bayar" readonly class="form-control">
                </div>
              </div>
            </div>
          </div>
        </div>     
        <div class="clear-fix"></div>
        <div class="optionBox">
   
</div>
        <br>
        <br>
        <h4 align="left">Transaksi</h4>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table id="penjualan" class="table table-responsive table-stripped">
              <thead>
                <th>No</th>
                <th>Transaksi</th>
                <th>Range Tarif</th>
                <th>Kapasitas</th>
                <th>Satuan</th>
                <th>Tarif</th>
                <th>Hapus</th>
              </thead>
              <tbody id="tbody_transaksi">                
                    <input id="idf" value="1" type="hidden" />

              </tbody>
  
            
            </table>
            <button id='btn-add-transaksi' type="button" class="btn btn-danger pull-right" onclick="tambahHobi(); return false;"><i class="fa fa-plus"></i> Add Transaksi</button>
          </div>
        </div>
    </div>
    </form>
</div>
</div>


<script type="text/javascript">

    function currency(input) {
		var input = input.toString().replace(/[\D\s\._\-]+/g, "");
		input = input ? parseInt(input, 10) : 0;
		return (input === 0) ? "" : input.toLocaleString("en-US");
	}

	$(function () {
		$('.datetimepicker').datetimepicker({
			viewMode: 'days',
			format: 'MM-DD-YYYY'
		});

	});

	$("#pilih_unit").change(function () {


        $("#label_transaksi").show();

		


			url = '<?=site_url(); ?>/transaksi_lain/p_registrasi_liaison_officer/lihat_unit';
			var pilih_unit = $("#pilih_unit").val();
			//console.log(this.value);
			$.ajax({
				type: "post",
				url: url,
				data: {
					pilih_unit: pilih_unit
				},
				dataType: "json",
				success: function (data) {
					console.log(data);


				
					$("#project_name").val(data.project_name);
					$("#kawasan_name").val(data.kawasan_name);
					$("#blok_name").val(data.blok_name);
					$("#unit").val(data.no_unit);
					$("#customer").val(data.customer_name);




					$("#jenis").val(data.unit_type);
					$("#alamat").val(data.customer_address);
					$("#mobile_phone").val(data.customer_mobilephone);
					$("#no_document").val(data.customer_code);
          $("#tanggal_st").val(data.tanggal_st);
					$("#tunggakan_retribusi").val('');
					$("#luas_tanah").val(data.luas_bangunan);
					$("#luas_bangunan").val(data.luas_tanah);
					$("#tarif_pl").val('');
					$("#total").val('');
					$("#status_bayar").val('');



         }


			


			})




	


	});

	

    $("#diskon").keyup(function(){
        if($("#diskon").val()<=100){
            $("#jumlah_diskon").val(currency(parseInt($("#diskon").val().toString().replace(/[\D\s\._\-]+/g, ""))*parseInt($("#sub_total").val().toString().replace(/[\D\s\._\-]+/g, ""))/100));
            console.log(
                parseInt($("#total").val().toString().replace(/[\D\s\._\-]+/g, ""))
            );
            console.log(
                parseInt($("#jumlah_diskon").val().toString().replace(/[\D\s\._\-]+/g, ""))
            );
            $("#total").val(
                currency(
                parseInt($("#sub_total").val().toString().replace(/[\D\s\._\-]+/g, ""))-parseInt($("#jumlah_diskon").val().toString().replace(/[\D\s\._\-]+/g, ""))
                )
            );
        }else{
            $("#diskon").val(100);
        }
    });
</script>


<!-- jQuery -->
<script type="text/javascript">   
    $(function() {
        
        $('#btn-add-transaksi').click(function(){
            var row = "<tr>"
            +"</tr>";
        });
    });

    $("#btn-add-transaksi").click(function(){
        if($(".no").html()){
            idf = parseInt($(".no").last().html()) + 1;
        }else{
            idf = 1;
        }
        var str = "<tr id='srow" + idf + "'>"+
                "<td class='no'>"+idf+"</td>"+
                "<td>"+
                        "<select class='form-control select2' name='jenis_service[]'>"+
                            "<option value=''>--Pilih Jenis Service--</option>"+
                            "<?php foreach ($dataJenisService as $key => $v) {
    ?>"+
                                "<option value='<?=$v['id']; ?>'><?=$v['name']; ?> </option>"+
                            "<?php
} ?>"+
                        "</select>"+
                    "</td>"+
                    "<td>"+
                    "<div class='data_range'></div>" +
                    "</td>"+
                    "<td>" +
                    "<input type='text' name='kapasitas[]' class='form-control currency'>" + 
                    "</td>" +
                    "<td>" + 
                         "<select class='form-control select2' name='satuan[]' id='satuan'>" + 
                           "<option value='pcs'>Pcs</option>" +
                           "<option value='kbps'>Kbps</option>" + 
                           "<option value='kwh'>Kwh</option>" +   
                         "</select>" + 
                    "</td>" + 
                    "<td>" +
                    "<input type='text' name='tarif[]' readonly class='form-control currency'>" +
                    "</td>" +
          "<td> <a class='btn btn-danger' href='#' style=\"color:#3399FD;\" onclick='hapusElemen(\"#srow" + idf + "\"); return false;'><i class='fa fa-trash'></i> </a></td>"+
                "</tr>";
        $("#tbody_transaksi").append(str);
        $('.select2').select2({
      width: 'resolve'
    });
    });
  
  
  
  
   

function hapusElemen(idf) {
    $(idf).remove();
    var idf = document.getElementById("idf").value;
    idf = idf-1;
    document.getElementById("idf").value = idf;
}



</script>


