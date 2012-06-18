<!DOCTYPE html>
<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::css('bootstrap.min.css');
		print Asset::css('bootstrap-responsive.min.css');
		print Asset::css('autocomplete.css');
		print Asset::js('jquery-1.7.2.min.js');
		print Asset::js('jquery-ui.min.js');
		print Asset::js('jquery.ocupload-1.1.2.min.js');
		print \Helper\JsVarBase::render();
	?>
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/install/layout.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/public/redmond/jquery-ui-1.8.19.custom.css'); ?>">
	<script type="text/javascript" src="<?php print Uri::create('server/component/install/step' . $step . '.js'); ?>"></script>
</head>
<body>
	<div class="install-container">
		<div class="btn-group">
				<?php

					for($i = 1; $i <= 4; ++$i)
					{
						$active = $step == $i ? ' btn-primary' : '';
						print '<a class="btn' . $active . '" href="' . Uri::create('install/' . $i) . '">' 
								. __('steps.' . $i) .
							  '</a>';
					}

				?>
		</div>
		<div class="install-content">
			<?php $vars = get_defined_vars();unset($vars['__data']);unset($vars['__file_name']); ?>
			<?php print \View::forge('steps/' . $step,$vars) ?>
		</div>
	</div>
</body>
</html>