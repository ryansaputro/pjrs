<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script>
    $(document).ready(function () {
    $(".filter-date").text("Periode " + $('#minDate').val() + " - " + $('#maxDate').val());

    var oTable = $('#PQData').dataTable({
        "aaSorting": [[3, "desc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
        "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 
        'bServerSide': true,
        'sAjaxSource': '<?= site_url('reports/getProductSales' . ($warehouse_id ? '/' . $warehouse_id : '')) ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            // Push CSRF
            aoData.push({
                "name": "<?= $this->security->get_csrf_token_name() ?>",
                "value": "<?= $this->security->get_csrf_hash() ?>"
            });

            // Push date filter
            aoData.push({ "name": "start_date", "value": $('#minDate').val() });
            aoData.push({ "name": "end_date", "value": $('#maxDate').val() });

            $.ajax({
                'dataType': 'json', 
                'type': 'GET', 
                'url': sSource, 
                'data': aoData, 
                'success': fnCallback
            });
        },
        "aoColumns": [
            { "mData": "product_code" }, 
            { "mData": "product_name" }, 
            { "mData": "total", "mRender": formatQuantity }, 
            // { "mData": "date" }
        ],
    })
    .fnSetFilteringDelay()
    .dtFilter([
        {
            column_number: 0, // index pertama = product_code
            filter_default_label: "[<?= lang('product_code'); ?>]", 
            filter_type: "text"
        },
        {
            column_number: 1, // product_name
            filter_default_label: "[<?= lang('product_name'); ?>]", 
            filter_type: "text"
        },
        {
            column_number: 2, // total
            filter_default_label: "[<?= lang('total'); ?>]", 
            filter_type: "text"
        },
    ], "footer")

    $('#filter').click(function() {
        $(".filter-date").text("Periode " + $('#minDate').val() + " - " + $('#maxDate').val());
        $('#dateFilterModal').modal('hide');
        oTable.fnDraw();
    })
});
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-calendar-o"></i><?= lang('report_custom_sales') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')'; ?>
        </h2>

        <div class="box-icon mt-2 mb-2">
            <button class="btn btn-primary" data-toggle="modal" data-target="#dateFilterModal">
                <i class="fa fa-calendar-check-o"></i> Filter Tanggal
            </button>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <?php if (!empty($warehouses)) { ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("warehouses") ?>"></i>
                        </a>
                        <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li>
                                <a href="<?= site_url('reports/quantity_alerts') ?>">
                                    <i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <?php
                            foreach ($warehouses as $warehouse) {
                                echo '<li ' . ($warehouse_id && $warehouse_id == $warehouse->id ? 'class="active"' : '') . '><a href="' . site_url('reports/quantity_alerts/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('list_results'); ?></p>
                <b><h2 class="filter-date"></h2></b>


                <div class="table-responsive">
                    <table id="PQData" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-condensed table-hover table-striped dfTable reports-table">
                        <thead>
                        <tr class="active">
                            <th><?php echo $this->lang->line("product_code"); ?></th>
                            <th><?php echo $this->lang->line("product_name"); ?></th>
                            <th><?php echo $this->lang->line("total"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="4" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="dateFilterModal" tabindex="-1" role="dialog" aria-labelledby="dateFilterModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header bg-primary" style="color:white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
        <h4 class="modal-title" id="dateFilterModalLabel">Filter Berdasarkan Tanggal</h4>
      </div>
      
      <div class="modal-body">
        <form id="dateFilterForm">
          <div class="form-group">
            <label for="minDate">Tanggal Awal</label>
            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="minDate">
          </div>
          <div class="form-group">
            <label for="maxDate">Tanggal Akhir</label>
            <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="maxDate">
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button type="button" id="filter" class="btn btn-primary">Terapkan Filter</button>
    </div>
</div>
  </div>
</div>

<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var warehouse = $('#warehouse_id').val() || '';


        $('#pdf').click(function (event) {
            var start = $('#minDate').val();
            var end   = $('#maxDate').val();
            var warehouse = $('#warehouse_id').val();
            openAndDownload("<?= site_url('reports/exportProductSales/pdf') ?>?start_date=" 
                + encodeURIComponent(start) 
                + "&end_date=" + encodeURIComponent(end) 
                + (warehouse ? "&warehouse_id=" + encodeURIComponent(warehouse) : '')); 
        });
        $('#xls').click(function (event) {
            var start = $('#minDate').val();
            var end   = $('#maxDate').val();
            var warehouse = $('#warehouse_id').val();
            openAndDownload("<?= site_url('reports/exportProductSales/excel') ?>?start_date=" 
                + encodeURIComponent(start) 
                + "&end_date=" + encodeURIComponent(end) 
                + (warehouse ? "&warehouse_id=" + encodeURIComponent(warehouse) : '')); 
        });
        // $('#image').click(function (event) {
        //     event.preventDefault();
        //     html2canvas($('.box'), {
        //         onrendered: function (canvas) {
        //             var img = canvas.toDataURL()
        //             window.open(img);
        //         }
        //     });
        //     return false;
        // });
    });

    function openAndDownload(url) {
        var win = window.open(url, '_blank'); // buka tab baru
        // coba auto-close setelah 3 detik (cukup aman buat file udah terdownload)
        var timer = setInterval(function() {
            if (win.closed) {
                clearInterval(timer);
            } else {
                win.close();
                clearInterval(timer);
            }
        }, 3000);
    }
</script>
