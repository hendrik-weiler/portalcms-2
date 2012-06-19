<?php

namespace Helper;

class AjaxLoader
{

	protected static $_instances = 0;

	public static function _build_no_ajax_error($error)
	{
		switch($error['status'])
		{
			case 200:
			$error_html = '<div class="ui-widget">
				<div id="ajax_load_' . static::$_instances . '" class="ui-state-highlight ui-corner-all " style="padding:5px 10px;">
					<span class="ui-icon ui-icon-info" style="margin-right:5px;"></span>
					<strong>' . $error['title'] . '</strong>
					<p>' . $error['message'] . '</p>
				</div>
			</div>';
			break;
			case 404:
			$error_html = '<div class="ui-widget">
				<div id="ajax_load_' . static::$_instances . '" class="ui-state-highlight ui-corner-all ui-state-error" style="padding:5px 10px;">
					<span class="ui-icon ui-icon-alert" style="margin-right:5px;"></span>
					<strong>' . $error['title'] . '</strong>
					<p>' . $error['message'] . '</p>
				</div>
			</div>';
			break;
			default:
			$error_html = '';
			break;
		}
		return $error_html;
	}

	protected static function _build_html()
	{
		return '
		<div class="ui-widget">
			<div id="ajax_load_' . static::$_instances . '" class="ui-state-highlight ui-corner-all" style="padding:5px 10px;display:none;">
				<img src="' . \Uri::create('/assets/img/ajax_load.gif') . '" alt="loading" />
				<span class="ui-icon ui-icon-alert" style="margin-right:5px;"></span><strong>Loading...</strong>
				<p></p>
			</div>
		</div>
		';
	}

	protected static function _build_js($selector,$redirect,$path)
	{
		$js = '';
		$js .= '
		<script type="text/javascript">
			$("#ajax_load_' . static::$_instances . '").hide().find("i").hide();
			$("' . $selector . '").submit(function(e) {
				e.preventDefault();
				var ajax_load_selector = "#ajax_load_' . static::$_instances . '";
				$(ajax_load_selector).show();
				$.ajax({
				  type: "POST",
				  url: "' . $path . '",
				  dataType: "json",
				  data: { ajax_data : $(this).serializeArray() },
				  success: function(data) {
						var ajax_load_class;

						if(data.fuel_csrf_token)
							$("input[name=fuel_csrf_token]").attr("value",data.fuel_csrf_token);

						if(data.status == 404)
						{
							ajax_load_class = "ui-state-error";
							ajax_load_icon = "ui-icon-alert";
						}

						if(data.status == 200)
						{
							ajax_load_class = "ui-state-highlight";
							ajax_load_icon = "ui-icon-info";
						}

						$(ajax_load_selector)[0].className = "ui-corner-all";
						$(ajax_load_selector).addClass(ajax_load_class);
						$(ajax_load_selector).find("img").hide();
						$(ajax_load_selector).find("span")[0].className = "ui-icon";
						$(ajax_load_selector).find("span").addClass(ajax_load_icon).show();
						$(ajax_load_selector).find("strong").html(data.title);
						$(ajax_load_selector).find("p").html(data.message);
						$(ajax_load_selector).delay(10000).fadeOut(1000,function() {
						$("#ajax_load_' . static::$_instances . '")
								.removeClass(ajax_load_class)
								.addClass("btn-info")
								.find("h3")
								.html("Loading...")
								.parents()
								.find("p")
								.html("");
						});';
					if($redirect != false)
						$js .= 'if(data.status == 200) window.location.href = "' . $redirect . '";';
		$js .= '}
				})
			});
		</script>
		';

		return $js;
	}

	public static function get_input()
	{
		$data = array();
		$data['ajax_call'] = false;

		if(isset($_POST['ajax_data']))
		{
			$data['ajax_call'] = true;
			foreach ($_POST['ajax_data'] as $key => $value) 
				$data[$value['name']] = $value['value'];
		}
		else
		{
			$data = array_merge($data,$_POST);
		}

		$data['error_code'] = 0;

		return $data;
	}

	public static function get_response($input, $response)
	{
		if($input['ajax_call'])
		{
			return \Response::forge(\Helper\AjaxLoader::response($response));	
		}
		else
		{
			!isset($input['_redirect']) and $input['_redirect'] = '';
			if($input['error_code'] == 0)
				return \Response::redirect($input['_redirect']);
			else
				return \Response::redirect($input['_current'] . '?message=' . $input['error_code']);
		}
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
			'message' => $message,
			'fuel_csrf_token' => \Security::fetch_token(),
		));
	}

	public static function render($selector,$messages,$redirect,$path)
	{
		++static::$_instances;
		$html = '';

		if(isset($_GET['message']))
			$html .=  static::_build_no_ajax_error($messages[$_GET['message']]);

		$html .= static::_build_html();
		$html .= static::_build_js($selector,$redirect,$path);

		return $html;
	}
}