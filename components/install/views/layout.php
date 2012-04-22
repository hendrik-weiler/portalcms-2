<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::css('bootstrap.min.css');
		print Asset::css('bootstrap-responsive.min.css');
		print Asset::js('jquery-1.7.2.min.js');
	?>
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/install/layout.css'); ?>">
	<script type="text/javascript" src="<?php print Uri::create('server/component/install/layout.js'); ?>"></script>
</head>
<body>
	<div class="install-container">
		<div class="install-steps">
			<ul>
				<?php

					for($i = 1; $i <= 4; ++$i)
					{
						$active = $step == $i ? ' class="install-active"' : '';
						print '<li' . $active . '>' . __('steps.' . $i) . '</li>';
					}

				?>
			</ul>
		</div>
		<div class="install-content">
			<?php print \View::forge('steps/' . $step) ?>
		</div>
	</div>
</body>
</html>