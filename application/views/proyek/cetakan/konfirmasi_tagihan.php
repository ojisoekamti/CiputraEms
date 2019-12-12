<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='UTF-8'>
    <title>Konfirmasi Tagihan</title>
    <link href="<?= base_url() ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    .casabanti {
        font-family: 'casbanti';
    }

    .col-centered {
        float: none;
        margin: 0 auto;
    }

    .f-20 {
        font-size: 20px;
        font-weight: 700;
        line-height: 15px;
    }

    .f-14 {
        font-size: 14px;
        line-height: 10px;
    }

    html {
        margin-top: 200px;
        padding: 0px;
    }

    .f-15 {
        font-size: 14px;
        line-height: 10px;
    }

    table thead th,
    table tbody tr td,
    table tfoot tr td {
        font-size: 12px;
    }

    .f-12 {
        font-size: 12px;
        line-height: 10px;
    }

    .lh-18 {
        line-height: 18px;
    }

    .lh-15 {
        line-height: 15px;
    }

    .lh-5 {
        line-height: 5px;
    }

    .lh-8 {
        line-height: 5px;
    }

    #header {
        position: fixed;
        top: -200px;
    }

    .page_break {
        page-break-before: always;
    }
</style>

<body>
    <div id="header">
        <div style="width: fit-content;text-align: center; margin-top:20px">
            <img src="images/logoCiputra.png" width="15%" style="align-content:center">
        </div>

        <div>
            <div class="" style="width: fit-content;text-align: center; margin-top:5px; margin-bottom:200px">
                <p class="align-center f-20"><u>Informasi Tagihan Retribusi Estate</u></p>
                <p class="align-center f-20 casabanti"><?= $unit->project ?></p>
                <p class="align-center f-14"><?= $unit->project_address ?></p>
            </div>
        </div>
    </div>

    <div id="container">
        <div id="body">
            <div>
                <p class="f-15">Kepada Yth,</p>
                <p class="f-15 lh-15">Bpk/ibu <?= $unit->customer_name ?></p>
                <p class="f-15 lh-15"><?=$unit->alamat?></p>
                <p class="f-15">Perumahan <?= $unit->project ?></p>
            </div>
            <br>
            <div>
                <p class="f-15">Dengan Hormat,</p>
                <p class="f-15 lh-15">Dengan ini kami sampaikan informasi total tagihan
                    <?php
                    if ($periode_first == $periode_last) {
                        echo (" bulan " . strtolower($periode_last));
                    } else {
                        echo (" dari bulan " . strtolower($periode_last) . " sampai " . strtolower($periode_first));
                    }
                    ?>
                    , dengan perincian sebagai
                    berikut :</p>
            </div>
            <table class="table table-striped" style="margin-bottom:0">
                <thead>
                    <tr>
                        <th class="text-right">No</th>
                        <th class="text-right">Periode Tagihan</th>
                        <?php if ($total_air) : ?>
                        <th class="text-right">Meter Awal</th>
                        <th class="text-right">Meter Akhir</th>
                        <th class="text-right">Pakai</th>
                        <?php endif; ?>
                        <?php if ($total_lain) : ?>
                        <th class="text-right">LAIN(Rp.)</th>
                        <?php endif; ?>
                        <?php if ($total_air) : ?>
                        <th class="text-right">AIR(Rp.)</th>
                        <?php endif; ?>
                        <?php if ($total_lingkungan) : ?>
                        <th class="text-right">IPL(Rp.)</th>
                        <th class="text-right">PPN(Rp.)</th>
                        <?php endif; ?>
                        <th class="text-right">Denda(Rp.)</th>
                        <th class="text-right">Total(Rp.)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tagihan as $i => $v) :
                        ?>
                    <tr>
                        <td class="text-right"><?= $i + 1 ?></td>
                        <td class="text-right"><?= $v->periode ?></td>
                        <?php if ($total_air) : ?>
                        <td class="text-right"><?= $v->meter_awal ?></td>
                        <td class="text-right"><?= $v->meter_akhir ?></td>
                        <td class="text-right"><?= $v->meter_pakai ?></td>
                        <?php endif; ?>
                        <?php if ($total_lain) : ?>
                        <td class="text-right"><?= $v->tagihan_lain ?></td>
                        <?php endif; ?>
                        <?php if ($total_air) : ?>
                        <td class="text-right"><?= $v->tagihan_air ?></td>
                        <?php endif; ?>
                        <?php if ($total_lingkungan) : ?>
                        <td class="text-right"><?= $v->tagihan_lingkungan ?></td>
                        <td class="text-right"><?= $v->ppn_lingkungan ?></td>
                        <?php endif; ?>
                        <td class="text-right"><?= $v->total_denda ?></td>
                        <td class="text-right"><?= $v->total ?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>

                <tfoot>
                    <tr>

                        <td colspan="
                        <?php
                        if ($total_air) {
                            echo (4);
                        } else {
                            echo (2);
                        }
                        ?>
                        "><b>Grand Total :</b></td>
                        <?php if ($total_air) : ?>
                        <td class="text-right"><?= $total_pakai ?></td>
                        <?php endif; ?>
                        <?php if ($total_lain) : ?>
                        <td class="text-right"><?= $total_lain ?></td>
                        <?php endif; ?>
                        <?php if ($total_air) : ?>
                        <td class="text-right"><?= $total_air ?></td>
                        <?php endif; ?>
                        <?php if ($total_lingkungan) : ?>
                        <td class="text-right"><?= $total_lingkungan ?></td>
                        <td class="text-right"><?= $total_ppn ?></td>
                        <?php endif; ?>
                        <td class="text-right"><?= $total_denda ?></td>
                        <td class="text-right"><?= $total ?></td>
                    </tr>
                </tfoot>

            </table>
            <div <?php
                    if (($i + 1 >= 13 && $i + 1 <= 20) || (((($i + 1) - 20) % 23 >= 20) && ((($i + 1) - 21) % 23 <= 23)))
                        echo ("style='page-break-before: always;'");

                    ?>>
                <?php if($status_saldo_deposit==1):?>
                    <p class="lh-18 f-15" style="margin-bottom:6px;font-weight:bold;">
                        Saldo deposit sebesar : Rp.<?=$saldo_deposit?$saldo_deposit:0?>
                    </p>
                <?php endif;?>

                <p class="lh-18 f-15">
                    Jika Pembayaran dilakukan setelah tanggal 20 bulan berjalan akan dikenakan denda
                    kumulatif/penalti. Untuk Informasi lebih lanjut dapat menghubungi Customer Service di
                    kantor Estate Office
                    <?php
                    if ($unit->contactperson || $unit->phone) {
                        echo (" di ");
                        if ($unit->contactperson && $unit->phone) {
                            echo ("$unit->contactperson dan $unit->phone.");
                        } else if ($unit->contactperson) {
                            echo ("$unit->contactperson.");
                        } else if ($unit->phone) {
                            echo ("$unit->phone.");
                        }
                    } else {
                        echo (".");
                    }

                    ?>
                </p>
                <p class="lh-5">
                    Demikian Informasi yang dapat kami sampaikan, Atas kerjasamanya yang baik kami ucapkan terima
                    kasih.
                </p>
                <br>
                <div style="margin-top: 15px;margin-bottom:-100px;">
                    <table class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                        <tr>
                            <td class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <p class="lh-5 f-15">Hormat Kami,</p>
                                <p class="lh-5 f-15"><?= $unit->pt ?></p>
                                <?php if($ttd):?>
                                <img src="files/ttd/konfirmasi_tagihan/<?=$ttd?>" width="150px" height="150px" style="margin-top:10px"/>
                                <?php else:?>
                                <div style="height:150px;margin-top:10px">
                                </div>
                                <?php endif;?>
                                <p class="lh-5 f-15" ><u><?= $unit->pp_value ?></u></p>
                                <p class="lh-5 f-15"><?= $unit->pp_name ?></p>
                            </td>
                            <td>
                                <div style="border: 2px solid black; padding:10px">
                                    <?=$catatan?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>