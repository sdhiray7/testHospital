<?php $version = $this->db->get_where('settings', array('type' => 'version'))->row()->description;?>
<!-- Footer -->
<footer class="main">
	&copy; 2017 <strong>Bayanno Hospital Management System</strong>
    <strong class="pull-right"> VERSION <?php echo $version;?></strong>
    Developed by
	<a href="http://creativeitem.com"
    	target="_blank">Creativeitem</a>
</footer>
