<?php

namespace Helper;

class AjaxLoaderProgress
{

	protected static $_instances = 0;

	protected static function _build_html()
	{
		return '
		<div class="ui-widget">
			<div id="ajax_load_progressbar_' . static::$_instances . '"></div>
		</div>
		';
	}

	protected static function _build_js($selector,$redirect,$path,$params,$onstepcallback,$steps)
	{
		$params = preg_replace('/\n|\r\n|\r/','',$params);
		$js = '';
		$js .= '
		<script type="text/javascript">
			$("#ajax_load_progressbar_' . static::$_instances . '").hide().find("i").hide();
			$("' . $selector . '").live("click",function() {
				$.ajax_load_progressbar_selector = "#ajax_load_progressbar_' . static::$_instances . '";
				$.ajax_load_progressbar_steps = ' . $steps . '
				$.ajax_load_progressbar_progress_step = 100/' . $steps . ';
				$.ajax_load_progressbar_progress = 0;
				$.ajax_load_progressbar_data = ' . $params . ';
				$.ajax_load_progressbar_data_counter = 0;

				if($.ajax_load_progressbar_data.length == 0) return;

				$($.ajax_load_progressbar_selector).show().progressbar({value:0});
				function ajax_load_progressbar_call_' . static::$_instances . '(path,data)
				{
					$.getJSON(path,data,function(result) {
						$.ajax_load_progressbar_progress+=$.ajax_load_progressbar_progress_step;
						$( $.ajax_load_progressbar_selector ).progressbar({
							value: $.ajax_load_progressbar_progress
						});
						console.log(data);
						' . $onstepcallback . '(result,data);
						++$.ajax_load_progressbar_data_counter;
						if($.ajax_load_progressbar_data_counter >= $.ajax_load_progressbar_data.length)
						{
							$($.ajax_load_progressbar_selector).delay(1000).fadeOut(1000,function() {
								$(this).progressbar({value:0});';
								if($redirect != false)
									$js .= 'window.location.href = "' . $redirect . '";';
								$js .= '
							});
						}
						else
						{
							ajax_load_progressbar_call_' . static::$_instances . '(path,$.ajax_load_progressbar_data[$.ajax_load_progressbar_data_counter]);
						}
					});
				}
				ajax_load_progressbar_call_' . static::$_instances . '("' . $path . '",$.ajax_load_progressbar_data[0]);
			});
		</script>
		';

		return $js;
	}

	public static function to_r(Array $response_array)
	{
		$response = new \stdClass;
		$response->status = $response_array['status'];
		$response->title = $response_array['title'];
		$response->message = $response_array['message'];

		return $response;
	}

	public static function response($status,$title='',$message='')
	{
		if(is_object($status))
		{
			$title = $status->title;
			$message = $status->message;
			$status = $status->status;
		}

		return json_encode(array(
			'status' => $status,
			'title' => $title,
			'message' => $message
		));
	}

	public static function render($selector,$redirect,$path,$params,$onstepcallback,$steps)
	{
		++static::$_instances;
		$html = '';
		$html .= static::_build_html();
		$html .= static::_build_js($selector,$redirect,$path,$params,$onstepcallback,$steps);

		return $html;
	}
}