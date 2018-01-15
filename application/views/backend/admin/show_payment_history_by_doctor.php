<div class="panel-body">
    <form role="form" class="form-horizontal form-groups" action="<?php echo base_url(); ?>index.php?admin/payment_history_by_doctor_post" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('doctor'); ?></label>

        <div class="col-sm-7">
            <select name="doctor_id" class="select2" id = "doctor" required>
                <option value = ""><?php echo get_phrase('select_a_doctor'); ?></option>
                <?php
                $doctors = $this->db->get('doctor')->result_array();
                foreach ($doctors as $row2):
                    ?>
                    <option value="<?php echo $row2['doctor_id']; ?>">
                        <?php echo $row2['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label">
            <?php echo get_phrase('from_date'); ?></label>

        <div class="col-sm-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="from_date"
                       value="<?php echo date("m/d/Y"); ?>" >
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('to_date'); ?></label>

        <div class="col-sm-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="to_date"
                       value="" >
            </div>
        </div>
    </div>

        <button type="submit" class="btn btn-primary pull-right">
            <?php echo get_phrase('generate_report'); ?>
        </button>
    </form>

</div>

<br>
<?php
if(isset($invoice_info)){


?>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
    <tr>
        <th><?php echo get_phrase('invoice_number'); ?></th>
        <th><?php echo get_phrase('title'); ?></th>
        <th><?php echo get_phrase('patient'); ?></th>
        <th><?php echo get_phrase('doctor'); ?></th>
        <th><?php echo get_phrase('creation_date'); ?></th>
        <th><?php echo get_phrase('due_date'); ?></th>
        <th><?php echo get_phrase('vat_percentage'); ?></th>
        <th><?php echo get_phrase('discount_amount'); ?></th>
        <th><?php echo get_phrase('status'); ?></th>
        <th><?php echo get_phrase('options'); ?></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($invoice_info as $row) { ?>
        <tr>
            <td><?php echo $row['invoice_number'] ?></td>
            <td><?php echo $row['title'] ?></td>
            <td>
                <?php $name = $this->db->get_where('patient' , array('patient_id' => $row['patient_id'] ))->row()->name;
                echo $name;?>
            </td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['creation_timestamp'] ?></td>
            <td><?php echo $row['due_timestamp'] ?></td>
            <td><?php echo $row['vat_percentage'] ?></td>
            <td><?php echo $row['discount_amount'] ?></td>
            <td><?php echo $row['status'] ?></td>
            <td>
                <a  onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/show_invoice_details/<?php echo $row['invoice_id'] ?>');"
                    class="btn btn-default btn-sm btn-icon icon-left">
                    <i class="entypo-eye"></i>
                    View Invoice
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php
}
?>
<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    });
</script>