<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- select2 -->
<link href="<?= base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="<?= base_url() ?>vendors/select2/dist/js/select2.min.js"></script>
<link href="<?= base_url(); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>vendors/switchery/dist/switchery.min.js"></script>
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
        <div class="com-lg-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis LOI</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select required="" id="jenis" name="jenis_loi_id" class="form-control select2">
                        <option value="">--Pilih Jenis LOI--</option>
                        <?php foreach($dataJenis as $v){?>
                            <option value="<?=$v['id']?>"><?=$v['nama']?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Item</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Satuan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Masukkan Satuan" required>
                </div>
            </div>
           
        </div>
        <div class="com-lg-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga per Satuan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control currency" placeholder="Masukkan Harga per Satuan" value="0" id="harga_satuan" name="harga_satuan" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Item</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select required="" id="status_item" name="status_item" class="form-control select2">
                        <option value="">--Pilih Status Item--</option>
                        <option value="1">Dipinjamkan</option>
                        <option value="2">Hak Milik</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea class="form-control" rows="3" id="keterangan" name="keterangan" placeholder='Masukkan Keterangan' required></textarea>
                </div>
            </div>
		</div>
		<div class="col-md-12">
            <div class="form-group">
                <div class="center-margin">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <a id="submit" type="submit" class="btn btn-success">Submit</a>
                </div>
            </div>
        </div>
    </form>

    <script src="<?= base_url(); ?>vendors/jquery.validation/dist/jquery.validate.min.js"></script>
    <script>
        function notif(title, text, type) {
			new PNotify({
				title: title,
				text: text,
				type: type,
				styling: 'bootstrap3'
			});
		}

        // $("#jenis").change(function(){
        //     $("#nama").removeAttr("disabled");
        //     $("#satuan").removeAttr("disabled");
        //     $("#harga_satuan").removeAttr("disabled");
        //     $("#status_item").removeAttr("disabled");
        //     $("#keterangan").removeAttr("disabled");
        // });

        function validateForm()
        {
            var nama = $("#nama").val();
            var satuan = $("#satuan").val();
            var harga_satuan = $("#harga_satuan").val();
            var keterangan = $("#keterangan").val();
            var channel = $("#jenis_item").val();
            // if(nama == "",satuan == "",harga_satuan =="0")
            // {
            //     alert("Tolong dilengkapi");
            //     return false;
            // }

            if(nama ==""){
                alert("Tolong lengkapi inputan label nama item");
                location.reload();
                return false;
            }
            if(satuan==""){
                alert("Tolong lengkapi inputan label satuan");
                location.reload();
                return false;
            }
            if(harga_satuan==""){
                alert("Tolong lengkapi inputan label harga satuan");
                location.reload();
                return false;
            }
            if(channel==""){
                alert("Tolong lengkapi inputan label kegunaan")
            }
            return( true );
        }

        $(function() {

            $('.select2').select2();
            // var $form = $(this);
            // if(!$form.valid()) return false;
            // $("#form").validate();
            
            $("#submit").click(function(e){
                validateForm();
                e.preventDefault();
                
                $.ajax({
                    type: "GET",
                    data: $("#form").serialize(),
                    url: "<?= site_url() ?>/P_master_item_loi/ajax_save",
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
    </script>