<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="fa fa-plus"></i> &nbsp;
                    <?php echo get_phrase('add_invoice'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open(base_url() . 'index.php?accountant/invoice_add/create', array('class' => 'form-horizontal form-groups invoice-add', 'enctype' => 'multipart/form-data')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('invoice_title'); ?></label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="title" id="title" data-validate="required"
                               data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('invoice_number'); ?></label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="invoice_number"  value="<?php echo rand(10000, 100000); ?>"  readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?></label>

                    <div class="col-sm-7">
                        <select name="patient_id" class="select2" id = "patient" required>
                            <option value = ""><?php echo get_phrase('select_a_patient'); ?></option>
                            <?php
                            $patients = $this->db->get('patient')->result_array();
                            foreach ($patients as $row2):
                                ?>
                                <option value="<?php echo $row2['patient_id']; ?>">
                                    <?php echo $row2['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


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
                        <?php echo get_phrase('creation_date'); ?></label>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                            <input type="text" class="form-control datepicker" name="creation_timestamp"
                                   value="<?php echo date("m/d/Y"); ?>" >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('due_date'); ?></label>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                            <input type="text" class="form-control datepicker" name="due_timestamp"
                                   value="" >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('vat_percentage'); ?></label>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="entypo-info-circled"></i></span>
                            <input type="text" class="form-control" name="vat_percentage"
                                   value="" >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('discount_amount'); ?></label>

                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="entypo-info-circled"></i></span>
                            <input type="text" class="form-control" name="discount_amount"
                                   value="" >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('payment_status'); ?></label>

                    <div class="col-sm-7">
                        <select name="status" class="select2" id = "payment_status" required>
                            <option value= ""><?php echo get_phrase('select_a_status'); ?></option>
                            <option value="paid"><?php echo get_phrase('paid'); ?></option>
                            <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
                        </select>
                    </div>
                </div>

                <hr>

                <!-- FORM ENTRY STARTS HERE-->
                <div id="invoice_entry">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('invoice_entry'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="entry_description[]"  value=""
                                   placeholder="<?php echo get_phrase('description'); ?>" >
                        </div>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="entry_amount[]"  value=""
                                   placeholder="<?php echo get_phrase('amount'); ?>" min=0>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-danger" onclick="deleteParentElement(this)">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>

                    </div>
                </div>
                <!-- FORM ENTRY ENDS HERE-->


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                        <button type="button" class="btn btn-primary btn-sm"
                                onClick="add_entry()">
                            <i class="fa fa-plus"></i> &nbsp;
                            <?php echo get_phrase('add_invoice_entry'); ?>
                        </button>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                        <button type="submit" class="btn btn-info" id="submit-button">
                            <?php echo get_phrase('create_new_invoice'); ?></button>
                        <span id="preloader-form"></span>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    // CREATING BLANK INVOICE ENTRY
    var blank_invoice_entry = '';
    $(document).ready(function () {
        blank_invoice_entry = $('#invoice_entry').html();
        //$('#submit-button').attr('disabled', true);
    });

    function add_entry()
    {
        $("#invoice_entry").append(blank_invoice_entry);
    }

    // REMOVING INVOICE ENTRY
    function deleteParentElement(n) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    }
  //   var payment_status;
  //   var patient;
  //   $('#payment_status').change(function(){
  //     payment_status = $('#payment_status').val();
  //     check_button();
  //   });
  //   $('#patient').change(function(){
  //     patient = $('#patient').val();
  //     check_button();
  //   });
  // function check_button(){
  //   if (typeof payment_status !== "undefined" && payment_status !== '' && typeof patient !== "undefined" && patient !== '') {
  //     console.log('payment_status: '+payment_status+' Patient: '+patient);
  //     $('#submit-button').removeAttr('disabled');
  //   }
  //   else{
  //     $('#submit-button').attr('disabled', true);
  //   }
  // }

</script>
