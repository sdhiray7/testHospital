
<div class="panel panel-primary" data-collapsed="0">
    
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url();?>index.php?admin/frontend/blog"
                   class="btn btn-info">
                    <i class="fa fa-angle-left"></i>&nbsp;<?php echo get_phrase('back_to_blog_list');?>
                </a>
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
            <form action="<?php echo base_url();?>index.php?admin/frontend_settings/blog_edit/<?php echo $blog->frontend_blog_id;?>" 
                method="post" class="form-groups form-horizontal"
                    enctype="multipart/form-data">

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">
                        <?php echo get_phrase('blog_title');?>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="title"
                            value="<?php echo $blog->title;?>"
                                required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">
                        <?php echo get_phrase('short_description');?>
                    </label>
                    <div class="col-sm-6">
                        <textarea rows="3" class="form-control" name="short_description"
                            required><?php echo $blog->short_description;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-ta" class="col-sm-3 control-label">
                        <?php echo get_phrase('blog_post'); ?>
                    </label>
                    <div class="col-sm-8">
                        <textarea name="blog_post" class="form-control html5editor" rows="15"
                            id="field-ta" data-stylesheet-url="assets/css/wysihtml5-color.css"><?php echo $blog->blog_post;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <?php echo get_phrase('main_image'); ?>
                    </label>
                    <div class="col-sm-6">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 267px; height: 150px;" 
                                data-trigger="fileinput">
                                <img src="<?php echo base_url();?>uploads/frontend/blog_images/<?php echo $blog->frontend_blog_id;?>.jpg" 
                                    alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" 
                                style="max-width: 267px; max-height: 150px"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileinput-new"><?php echo get_phrase('select_image');?></span>
                                    <span class="fileinput-exists"><?php echo get_phrase('change');?></span>
                                    <input type="file" name="blog_image" accept="image/*">
                                </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">
                                <?php echo get_phrase('remove');?>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">
                        <?php echo get_phrase('publish_on_website');?>
                    </label>
                    <div class="col-sm-6">
                        <select name="published" class="selectboxit">
                            <option value="0"
                                <?php if ($blog->published == 0) echo 'selected';?>><?php echo get_phrase('no');?></option>
                            <option value="1"
                                <?php if ($blog->published == 1) echo 'selected';?>><?php echo get_phrase('yes');?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"></label>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-chech"></i> <?php echo get_phrase('update');?>
                        </button>
                    </div>
                </div>

            </form>
        </div>       
        
    </div>

</div>