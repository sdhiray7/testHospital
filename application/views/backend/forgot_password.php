<!doctype html>
<?php
$system_name  = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
?>

<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        <?php echo get_phrase('reset_password'); ?> | <?php echo $system_name; ?>
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?php echo base_url();?>uploads/favicon.png">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/login_page/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/login_page/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/login_page/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/login_page/css/style.css">
    <link rel="stylesheet"
          href="<?php echo base_url();?>assets/common/izitoast/css/iziToast.min.css" type="text/css">
    <script src="<?php echo base_url();?>assets/login_page/js/vendor/modernizr-2.8.3.min.js"></script>
    <!--    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600" rel="stylesheet">
</head>
<body>
<div class="main-content-wrapper">
    <div class="login-area">
        <div class="login-header">
            <a href="<?php echo base_url();?>index.php?login" class="logo">
                <img src="<?php echo base_url();?>uploads/logo.png" height="60" alt="">
            </a>
            <h2 class="title"><?php echo $system_name; ?></h2>
        </div>
        <div class="login-content">
            <form method="post" role="form" id="form_login"
                  action="<?php echo base_url();?>index.php?login/reset_password">
                <div class="form-group">
                    <input type="email" class="input-field" name="email"
                           placeholder="<?php echo get_phrase('enter_your_email');?>"
                           required autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">
                    <?php echo get_phrase('reset_password'); ?>
                </button>
            </form>

            <div class="login-bottom-links">
                <a href="<?php echo base_url();?>index.php?login" class="link">
                    <?php echo get_phrase('back_to_login'); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="image-area"></div>
</div>

<script src="<?php echo base_url();?>assets/login_page/js/vendor/jquery-1.12.0.min.js"></script>
<script src="<?php echo base_url();?>assets/common/izitoast/js/iziToast.min.js"></script>


<?php if ($this->session->flashdata('error_message') != '') { ?>
    <script>
        iziToast.error({
            title: '<?php echo get_phrase('error');?>',
            message: '<?php echo $this->session->flashdata('error_message');?>',
        });
    </script>
<?php } ?>

<?php if ($this->session->flashdata('success_message') != '') { ?>
    <script>
        iziToast.success({
            title: '<?php echo get_phrase('success');?>',
            message: '<?php echo $this->session->flashdata('success_message');?>',
        });
    </script>
<?php } ?>


</body>
</html>
