<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div style="float:right">
    <h2>
        <button class="btn btn-primary" onClick="window.location.href='<?=site_url()?>/Transaksi_lain/P_unit_sewa/add'">
            <i class="fa fa-plus"></i>
            Tambah
        </button>
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
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <table class="table table-striped jambo_table bulk_action tableDT">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kawasan</th>
                            <th>Blok</th>
                            <th>No. Unit</th>
                            <th>Range Harga Sewa</th>
                            <th>Tanggal Mulai Boleh di Sewakan</th>
                        </tr>
                    </thead>
					<tfoot id="tfoot" style="display: table-header-group">
                        <tr>
                            <th>No</th>
                            <th>Kawasan</th>
                            <th>Blok</th>
                            <th>No. Unit</th>
                            <th>Range Harga Sewa</th>
                            <th>Tanggal Mulai Boleh di Sewakan</th>                        
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $i = 0;
                            foreach ($data as $key => $v){
                            $i++;
                            echo('<tr>');
                                echo("<td>$i</td>");
                                echo("<td>$v->kawasan</td>");
                                echo("<td>$v->blok</td>");
                                echo("<td>$v->no_unit</td>");
                                echo("<td>$v->harga_sewa</td>");
                                echo("<td>$v->tgl_mulai</td>");
                            echo('</tr>');
                            }?>                
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>