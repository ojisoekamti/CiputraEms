<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div style="float:right">
    <h2>
        <!-- <button class="btn btn-primary" onClick="window.location.href='<?= site_url() ?>/Transaksi_lain/P_unit_sewa/add'">
            <i class="fa fa-plus"></i>
            Kirim
        </button> -->
        <button class="btn btn-warning" onClick="window.history.back()" disabled>
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
    <div class="modal fade" id="detail" data-backdrop="static" data-keyboard="false">
        <div class="">
            <div class="modal-content" style="margin-top:100px;">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Detail<span class="grt"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <table class="tableDT3 table table-striped jambo_table bulk_action">
                            <tbody>
                                <tr>
                                    <td>Project</td>
                                    <td><?=$project_name?></td>
                                </tr>
                                <tr>    
                                    <td>PT</td>
                                    <td id="detail_pt"></td>
                                </tr>
                                <tr>    
                                    <td>Cara Bayar</td>
                                    <td id="detail_cara_bayar"></td>
                                </tr> 
                                <tr>
                                    <td>Coa Cara Bayar</td>
                                    <td id="detail_coa_cara_bayar"></td>
                                </tr>
                                <tr>
                                    <td>Total Nilai Item</td>
                                    <td id="detail_total_nilai_item"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="col-md-12">
                            <a id="btn-validasi-detail" class="btn btn-primary col-md-3" style="float:right;height:64px;padding-top:20px;font-size:20px">Validasi</a>
                        </div>
                        <div class="col-md-12">
                            <a id="btn-kirim-detail" class="btn btn-primary col-md-3" style="float:right;height:64px;padding-top:20px;font-size:20px" disabled>Kirim</a>
                        </div>
                    </div>
                    <table class="tableDT3 table table-striped jambo_table bulk_action">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Coa Item</th>
                                <th>Nilai (Rp.)</th>
                                <th>Status</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_detail">

                        </tbody>
                        <tfoot id="tfoot_detail">
                            <tr>
                                <th>Item</th>
                                <th>Coa Item</th>
                                <th>Nilai (Rp.)</th>
                                <th>Status</th>
                                <th>Pesan</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="x_content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <table class="table table-striped jambo_table bulk_action tableDT">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>PT</th>
                            <th>Cara Bayar</th>
                            <th>Coa Cara Bayar</th>
                            <th>Nilai</th>
                            <!-- <th>Kirim</th> -->
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tfoot id="tfoot" style="display: table-header-group">
                        <tr>
                            <th>No</th>
                            <th>PT</th>
                            <th>Cara Bayar</th>
                            <th>Coa Cara Bayar</th>
                            <th>Nilai</th>
                            <!-- <th>Kirim</th> -->
                            <th>Detail</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($data as $key => $v) {
                            $i++;
                            echo ('<tr>');
                            echo ("<td>$i</td>");
                            echo ("<td>$v->pt</td>");
                            echo ("<td>$v->cara_pembayaran</td>");
                            echo ("<td>$v->coa_cara_pembayaran</td>");
                            echo ("<td class='text-right'>" . number_format($v->nilai_item) . "</td>");
                            // echo ("<td class='col-md-1'><a class='btn btn-primary col-md-12' pt_id='$v->pt_id' cara_pembayaran_id='$v->cara_pembayaran_id'>Kirim</a></td>");
                            echo ("<td class='col-md-1'>
                                    <a data-toggle='modal' data-target='#detail' class='btn-detail btn btn-primary col-md-12' pt_id='$v->pt_id' cara_pembayaran_id='$v->cara_pembayaran_id'>Detail</a>
                                </td>");

                            echo ('</tr>');
                        } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    function notif(title, text, type) {
        new PNotify({
            title: title,
            text: text,
            type: type,
            styling: 'bootstrap3'
        });
    }

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
    $(function() {
        $("#btn-kirim-detail").click(function(){
            var cara_pembayaran_id = $(this).attr("cara_pembayaran_id");
            var pt_id = $(this).attr("pt_id");
            console.log("cara_pembayaran_id "+cara_pembayaran_id);
            console.log("pt_id "+pt_id);
            $.ajax({
                type: "GET",
                data: {
                    pt_id: $(this).attr("pt_id"),
                    cara_pembayaran_id: $(this).attr("cara_pembayaran_id"),
                    total_nilai : unformatNumber($("#detail_total_nilai_item").html()).substr(4)
                },
                url: '<?=site_url()?>/Transaksi/P_voucher_tagihan/ajax_kirim',
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if(data.result == 1){
                        console.log("a[cara_pembayaran_id='"+cara_pembayaran_id+"'][pt_id='"+pt_id+"']");
                        console.log("cara_pembayaran_id "+cara_pembayaran_id);
                        console.log("pt_id "+pt_id);
						notif('Sukses', 'Voucher Berhasil dibuat', 'success');
                        $("#btn-kirim-detail").hide();
                        $("#btn-validasi-detail").hide();
                        $("a[cara_pembayaran_id='"+cara_pembayaran_id+"'][pt_id='"+pt_id+"']").parents("tr").remove()
                    }else
						notif('Gagal', 'Voucher Gagal di buat, coba lagi', 'danger');
                }
            });
        });

        $("#btn-kirim-detail").hide();

        $("#btn-validasi-detail").click(function() {
            var validasi = 0;
            var loading = 0;

            $.each($("#tbody_detail").children(), function( i, v ) {
                console.log(v);
                console.log(v.id);
                $("#loading").show();

                $.ajax({
                    type: "GET",
                    data: {
                        id: v.id,
                        total_nilai : unformatNumber($("#detail_total_nilai_item").html()).substr(4)
                    },
                    url: '<?=site_url()?>/Transaksi/P_voucher_tagihan/ajax_validasi',
                    dataType: "json",
                    success: function(data) {
                        if(data.result == 1){
                            $("#tbody_detail").children().eq(i).children().eq(8).html("Sukses");
                            validasi++;
                            loading++;
                            $("#loading").show();
                        }else{
                            $("#tbody_detail").children().eq(i).children().eq(8).html("Error");
                            loading++;
                            $("#loading").show();
                        }
                        $("#tbody_detail").children().eq(i).children().eq(9).html(data.message);
                        if($("#tbody_detail").children().length == validasi){
                            $("#btn-kirim-detail").attr("disabled",false);
                            $("#btn-kirim-detail").show();
                        }else{
                            $("#btn-kirim-detail").attr("disabled",true);
                            $("#btn-kirim-detail").hide();
                        }
                        if($("#tbody_detail").children().length == loading){
                            $("#loading").hide();
                        }else{
                            $("#loading").show();
                        }
                    }
                });
            })
        })
        $(".btn-detail").click(function() {
            $("#btn-kirim-detail").hide();
            $("#btn-kirim-detail").attr("pt_id",$(this).attr("pt_id"));
            $("#btn-kirim-detail").attr("cara_pembayaran_id",$(this).attr("cara_pembayaran_id"));
            $("#btn-validasi-detail").show();

            
            url = '<?= site_url() ?>/Transaksi/P_voucher_tagihan/ajax_get_detail_gabungan';
            $.ajax({
                type: "GET",
                data: {
                    pt_id: $(this).attr('pt_id'),
                    cara_pembayaran_id: $(this).attr('cara_pembayaran_id')
                },
                url: url,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#detail_pt").html(data[0].pt);
                    $("#detail_cara_bayar").html(data[0].cara_pembayaran);
                    $("#detail_coa_cara_bayar").html(data[0].coa_cara_pembayaran);
                    
                    $("#tbody_detail").html("");
                    var total = 0;
                    $.each(data, function( i, v ) {
                        total += v.nilai_item;
                        var str = "<tr id='"+v.id+"."+v.item.substr(0,v.item.indexOf("-")-1)+"'>";
                        str += "<td>"+v.item+"</td>";
                        str += "<td>"+v.item_coa+"</td>";
                        str += "<td class='text-right'>"+formatNumber(v.nilai_item)+"</td>";
                        str +=  "<td>"+
                                    "<div style='width:100%;height:100%' class='col-md-offset-4 lds-double-ring'></div>"+
                                "</td>";
                        str += "<td></td>";
                        str += "</tr>";
                        console.log(str);
                        $("#tbody_detail").append(str);

                    });
                    // var str = "<tr>";
                    // str += "<td colspan=5></td>";
                    // str += "<td>"+total+"</td>";
                    // str += "<td></td><td></td><td></td><td></td>";

                    // str += "</tr>";
                    $("#detail_total_nilai_item").html("Rp. "+formatNumber(total));



                }
            });

        });
    });
</script>