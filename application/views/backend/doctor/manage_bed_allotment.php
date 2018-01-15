<button onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_bed_allotment/');" 
    class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_bed_allotment'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('bed_number');?></th>
            <th><?php echo get_phrase('bed_type');?></th>
            <th><?php echo get_phrase('patient');?></th>
            <th><?php echo get_phrase('allotment_time');?></th>
            <th><?php echo get_phrase('discharge_time');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($bed_allotment_info as $row) { ?>   
            <tr>
                <td>
                    <?php $bed_number = $this->db->get_where('bed' , array('bed_id' => $row['bed_id'] ))->row()->bed_number;
                        echo $bed_number;?>
                </td>
                <td>
                    <?php $type = $this->db->get_where('bed' , array('bed_id' => $row['bed_id'] ))->row()->type;
                        echo $type;?>
                </td>
                <td>
                    <?php $name = $this->db->get_where('patient' , array('patient_id' => $row['patient_id'] ))->row()->name;
                        echo $name;?>
                </td>
                <td><?php echo date("m/d/Y", $row['allotment_timestamp']); ?></td>
                <td><?php echo date("m/d/Y", $row['discharge_timestamp']); ?></td>
                <td>
                    <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_bed_allotment/<?php echo $row['bed_allotment_id']?>');" 
                        class="btn btn-default btn-sm">
                            <i class="fa fa-pencil"></i>&nbsp;
                            <?php echo get_phrase('edit');?>
                    </a>
                    <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?doctor/bed_allotment/delete/<?php echo $row['bed_allotment_id'];?>')"
                        class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i>&nbsp;
                        <?php echo get_phrase('delete');?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

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

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    });
</script>