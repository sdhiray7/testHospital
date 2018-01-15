<?php $patient_info = $this->db->get('patient')->result_array(); ?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_appointment'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups" enctype="multipart/form-data"
                    action="<?php echo base_url(); ?>index.php?doctor/appointment/create" method="post">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>

                        <div class="col-sm-7">
                            <div class="date-and-time">
                                <input type="text" name="date_timestamp" class="form-control datepicker" data-format="D, dd MM yyyy"
                                       placeholder="<?php echo get_phrase('appointment_date');?>" required>
                                <input type="text" name="time_timestamp" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="00:05 AM" data-show-meridian="false" data-minute-step="5"  placeholder="time here" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?></label>

                        <div class="col-sm-7">
                            <select name="patient_id" class="select2" required>
                                <option value=""><?php echo get_phrase('select_patient'); ?></option>
                                <?php foreach ($patient_info as $row) { ?>
                                        <option value="<?php echo $row['patient_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-7 col-sm-offset-3">
                            <input type="checkbox" id="notify" name="notify" value="checked" checked>
                            <label class="control-label" for="notify"><?php echo get_phrase('notify_patient_with_') . 'SMS'; ?></label>
                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> <?php echo get_phrase('save');?>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
