<button onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_appointment');" 
    class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_appointment'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th></th>
            <th><?php echo get_phrase('date');?></th>
            <th><?php echo get_phrase('patient');?></th>
            <th><?php echo get_phrase('doctor');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($appointment_info as $row) { ?>   
            <tr>
                <td></td>
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
                    <a  onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_appointment/<?php echo $row['appointment_id']?>');" 
                        class="btn btn-info btn-sm">
                            <i class="fa fa-pencil"></i>&nbsp;
                        <?php echo get_phrase('edit');?>
                    </a>
                    <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?doctor/appointment/delete/<?php echo $row['appointment_id'];?>')"
                        class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i>&nbsp;
                            <?php echo get_phrase('delete');?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="row">
    <!-- CALENDAR-->
    <div class="col-md-12 col-xs-12">    
        <div class="panel panel-primary " data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fa fa-calendar"></i>
                    <?php echo get_phrase('event_schedule'); ?>
                </div>
            </div>
            <div class="panel-body" style="padding:0px;">
                <div class="calendar-env">
                    <div class="calendar-body">
                        <div id="notice_calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    
    $(document).ready(function()
    {
        var calendar = $('#notice_calendar');
				
        $('#notice_calendar').fullCalendar
        ({
            header:
            {
                left: 'title',
                right: 'month,agendaWeek,agendaDay today prev,next'
            },
            
            defaultView: 'agendaDay',

            //defaultView: 'basicWeek',

            editable: false,
            firstDay: 1,
            height: 530,
            droppable: false,

            events:
            [
                <?php
                $doctor_id      = $this->session->userdata('login_user_id');
                $appointments   = $this->db->get_where('appointment' , array('doctor_id' => $doctor_id ))->result_array();
                foreach ($appointments as $row):
                ?>
                    {
                        title   :   "<?php  $name = $this->db->get_where('patient' , 
                                                array('patient_id' => $row['patient_id'] ))->row()->name;
                                            echo $name;?>",
                        start   :   new Date(<?php echo date('Y', $row['timestamp']); ?>, 
                                        <?php echo date('m', $row['timestamp']) - 1; ?>, 
                                        <?php echo date('d', $row['timestamp']); ?>,
                                        <?php echo date('H', $row['timestamp']); ?>),
                        allDay: false
                    },
                <?php endforeach ?>
            ]
        });
    });
</script>