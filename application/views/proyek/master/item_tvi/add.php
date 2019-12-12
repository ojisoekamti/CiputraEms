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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Item</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control" required name="nama" required placeholder="Masukkan Nama">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Satuan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control" required name="satuan" placeholder="Masukkan Satuan">
                </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga per Satuan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control currency" required placeholder="Masukkan Harga per Satuan" value="0" name="harga_satuan">
                </div>
            </div>
           
        </div>
        <div class="com-lg-6 col-md-6 col-xs-6">
			
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea class="form-control" rows="3" name="keterangan" placeholder='Masukkan Keterangan'></textarea>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Channel TV</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="">
                        <label>
                            <input id="channel" type="checkbox" required class="js-switch" name="is_channel" value='1' /> Aktif
                        </label>
                    </div>
                </div>
            </div> -->
            <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Channel TV</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="">
                        <label>
                            <input type="checkbox" name="is_channel[]" id="channel" value="0" class="flat" data-parsley-multiple="is_channel" style="position: absolute; opacity: 0;">Internet
                            <br>
                            <input type="checkbox" name="is_channel[]" id="channel" value="1" class="flat" data-parsley-multiple="is_channel" style="position: absolute; opacity: 0;">TV
                        </label>
                    </div>
                </div>
            </div> -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kegunaan</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <label>
                        <select required="" id="channel" name="is_channel" class="form-control select2">
                            <option value="3">Semua</option>
                            <option value="0">Internet</option>
                            <option value="1">TV</option>
                        </select>
                    </label>
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


    <script>
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
                    type: "GET",
                    data: $("#form").serialize(),
                    url: "<?= site_url() ?>/P_master_item_tvi/ajax_save",
                    dataType: "json",
                    success: function(data) {
                        if (data.status)
                            notif('Sukses', data.message, 'success');
                        else
                            notif('Gagal', data.message, 'danger');
                    }
                });
            });
        });
    </script>