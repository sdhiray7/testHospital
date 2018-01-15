<?php
$department_info = $this->db->get('department')->result_array();
$single_doctor_info = $this->db->get_where('doctor', array('doctor_id' => $param2))->result_array();
foreach ($single_doctor_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_doctor'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups validate" action="<?php echo base_url(); ?>index.php?admin/doctor/update/<?php echo $row['doctor_id']; ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['name']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>

                            <div class="col-sm-7">
                                <input type="email" name="email" class="form-control" id="field-1" value="<?php echo $row['email'];?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>

                            <div class="col-sm-7">
                                <textarea name="address" rows="5" class="form-control" id="field-ta"><?php echo $row['address']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="phone" class="form-control" id="field-1" value="<?php echo $row['phone']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('department'); ?></label>

                            <div class="col-sm-7">
                                <select name="department_id" class="form-control" required>
                                    <option value=""><?php echo get_phrase('select_department'); ?></option>
                                    <?php foreach ($department_info as $row2) { ?>
                                        <option value="<?php echo $row2['department_id']; ?>" <?php if ($row['department_id'] == $row2['department_id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('profile'); ?></label>

                            <div class="col-sm-9">
                                 <textarea name="profile" class="form-control html5editor" id="field-ta" data-stylesheet-url="assets/css/wysihtml5-color.css">
                                    <?php echo $row['profile']; ?>
                                </textarea>
                            </div>
                        </div>

                        <?php $social = json_decode($row['social_links']);?>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label">
                                <?php echo get_phrase('social_links');?>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="facebook"
                                       value="<?php echo $social[0]->facebook;?>">
                                <span class="description"><?php echo get_phrase('facebook_profile_link');?></span>
                                <br>
                                <input type="text" class="form-control" name="twitter"
                                       value="<?php echo $social[0]->twitter;?>">
                                <span class="description"><?php echo get_phrase('twitter_profile_link');?></span>
                                <br>
                                <input type="text" class="form-control" name="google_plus"
                                       value="<?php echo $social[0]->google_plus;?>">
                                <span class="description"><?php echo get_phrase('google_plus_link');?></span>
                                <br>
                                <input type="text" class="form-control" name="linkedin"
                                       value="<?php echo $social[0]->linkedin;?>">
                                <span class="description"><?php echo get_phrase('linkedin_profile_link');?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                            <div class="col-sm-5">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        <img src="<?php echo $this->crud_model->get_image_url('doctor' , $row['doctor_id']);?>" alt="...">
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
                                <i class="fa fa-check"></i> <?php echo get_phrase('update');?>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>
