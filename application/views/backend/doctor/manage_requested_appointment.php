<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('date');?></th>
            <th><?php echo get_phrase('patient');?></th>
            <th><?php echo get_phrase('doctor');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($requested_appointment_info as $row) { ?>   
            <tr>
                <td><?php echo date("d M, Y -  H:i", $row['timestamp']); ?></td>
                <td>
                    <?php $name = $this->db->get_where('patient' , array('patient_id' => $row['patient_id'] ))->row()->name;
                        echo $name;?>
                </td>
                <td>
                    <?php $name = $this->db->get_where('doctor' , array('doctor_id' => $row['doctor_id'] ))->row()->name;
                        echo $name;?>
                </td>
                <td>
                    <a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/approve_appointment/<?php echo $row['appointment_id']?>');"
                        class="btn btn-primary btn-sm">
                            <i class="fa fa-check"></i> &nbsp;
                            <?php echo get_phrase('approve');?>
                    </a>
                    <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?doctor/appointment_requested/delete/<?php echo $row['appointment_id'];?>')"
                        class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i> &nbsp;
                        <?php echo get_phrase('delete');?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>