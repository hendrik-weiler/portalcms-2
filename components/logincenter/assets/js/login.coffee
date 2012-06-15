$ ->
		selectors = "input[name=dev_user],input[name=dev_pass],input[name=prod_user],input[name=prod_pass]"
		availableTags = [
			'root'
		]
		$( selectors ).autocomplete({
			source: availableTags
		})