<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_receptionist'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups"
                    action="<?php echo base_url(); ?>index.php?admin/receptionist/create" method="post">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="name" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>

                        <div class="col-sm-7">
                            <input type="email" name="email" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('password'); ?></label>

                        <div class="col-sm-7">
                            <input type="password" name="password" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>

                        <div class="col-sm-7">
                            <textarea rows="5" name="address" class="form-control" id="field-ta"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="phone" class="form-control" id="field-1" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                        <div class="col-sm-7">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                    <img src="http://placehold.it/200x150" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="image" accept="image/*">
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

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
