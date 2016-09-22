<?php 

include TEMPLATES_HEADER;
include TEMPLATES_MENU;
?>

<body>
	<form method="POST" id="create_folder" action="<?= BASEURL ?>/index.php/main">
		<input type="submit" name="create_folder" value="Create folder"/>
	</form>
</body>
<?php
include TEMPLATES_FOOTER;
?>