<?php
/**
 * about_calorie_calculator Tab Contents
 * @type String
 * @author  Md. Zubaer Ahammed <contact@zubaer.com>
 */
?>
<div class="about_calorie_calculator">
	<?php $plugin_data = $calcalpro->get_plugin_data(); ?>
	<h2><?php echo $plugin_data['Name']; ?> - Version <span style="color: green"><?php echo $calcalpro->get_plugin_version(); ?></span></h2>
	Developed by - <?php echo $plugin_data['Author']; ?>
	<p><strong>Please contact me for help and support. Visit: <?php echo '<a href="'. $plugin_data['AuthorURI'] .'">'. $plugin_data['AuthorURI'] .'</a>'; ?> or Email me at: <a href="mailto:zubaerahammed223@gmail.com">zubaerahammed223@gmail.com</a> </strong></p>
</div>