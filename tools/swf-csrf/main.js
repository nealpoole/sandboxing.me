function createNewBox()
{
	var newSiteData = $('#site-base').clone(true);
	$(newSiteData).attr("id", '');

	$('input', newSiteData).val('');
	$('textarea', newSiteData).val('');

	newSiteData.appendTo('#site-list');

	return newSiteData;
}

function addNewInputRow(box)
{
	var newRow = $('table tr:last', box).clone(true);
	$('td:first input', newRow).val('');
	$('td:last input', newRow).val('');

	$('table tr:last', box).after(newRow);

	$('table tr:last td:first input', box).focus();

	return newRow;
}

function setPostFieldsEnabled(details, enable)
{
	$('tr.post-body', details).toggle(enable);
	$('fieldset.header-table', details).toggle(enable);
}

function initNewInputHandler()
{
	$('fieldset.expandable-table a').click(function() {
		addNewInputRow($(this).parents("fieldset"));
	});

	$('fieldset.expandable-table input').keypress(function(event) {
		if (event.which == '13') {
			event.preventDefault();
			addNewInputRow($(this).parents("fieldset"));
		}
	});
}

function initNewUrlHandler()
{
	$('#submit-info > p > a').click(function() {
		createNewBox();
	});
}

function initMethodToggleHandler()
{
	$('select[name="input[URL][method]"]').change(function() {
		setPostFieldsEnabled($(this).parents('div.site-details'), $(this).val() == "POST");
	});
}

function initSubmitHandler()
{
	$('#submit-form').click(function(event) {
		event.preventDefault();

		var completeRequest = 'swf_url=' + $('#swf-url').val() + '&';

		var requests = $('#site-list div.site-details');
		for (var i = 0; i < requests.length; ++i)
		{
			var url = $('form input.target-url',  requests[i]).val();
			completeRequest += $('form', requests[i]).serialize().replace(/input%5BURL%5D/g, 'input%5B' + url + '%5D');

			if (i !=  requests.length - 1)
				completeRequest += '&';
		}

		document.location.hash = encodeURIComponent(completeRequest);

		$.post('applet.php', completeRequest, function(content)
		{
			var ifrm = $('#applet-display iframe')[0];
			ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
			ifrm.document.open();
			ifrm.document.write(content);
			ifrm.document.close();
		});
	});

	$('#submit-form').keypress(function(event) {
		if (event.which == '13') {
			event.preventDefault();
			$('#submit-form').click();
		}
	});
}

function handleInitialSetup()
{
	if (document.location.hash !== '')
	{
		var input = document.location.hash.substr(1);
		var inputArray = input.split('&');

		if (inputArray.length == 1)
		{
			input = decodeURIComponent(input);
			inputArray = input.split('&');
		}

		var sites = [];

		for (var i = 0; i < inputArray.length; ++i)
		{
			var curInput = decodeURIComponent(inputArray[i].replace(/\+/g, ' '));

			if (curInput.split('=')[0] == 'swf_url')
			{
				$('#swf-url').val(curInput.split('=')[1]);
				continue;
			}

			var urlStart = curInput.indexOf('[') + 1;
			var urlEnd = curInput.indexOf(']', urlStart)
			var url = curInput.substr(urlStart, urlEnd - urlStart);

			if (sites[url] == undefined)
			{
				sites[url] = createNewBox();
			}

			$('form input.target-url', sites[url]).val(url);

			var typeStart = curInput.indexOf('[', curInput.indexOf(']')) + 1;
			var typeEnd = curInput.indexOf(']', typeStart);
			var inputType = curInput.substr(typeStart, typeEnd - typeStart);

			// We only remove content before the first equals sign, since that's our key.
			var inputValue = curInput.split('=');
			inputValue.shift();
			 inputValue = inputValue.join('=');

			switch (inputType)
			{
				case 'method':
					$('select[name="input[URL][method]"]', sites[url]).val(inputValue);
					$('select[name="input[URL][method]"]', sites[url]).change();
					break;
				case 'data':
					$('textarea[name="input[URL][data]"]', sites[url]).val(inputValue);
					break;
				case 'headerK':
					if ($('fieldset.header-table tr:last td:first input', sites[url]).val() != "")
						$('fieldset.header-table a', sites[url]).click();

					$('fieldset.header-table tr:last td:first input', sites[url]).val(inputValue);
					break;
				case 'headerV':
					if ($('fieldset.header-table tr:last td:last input', sites[url]).val() != "")
						$('fieldset.header-table a', sites[url]).click();

					$('fieldset.header-table tr:last td:last input', sites[url]).val(inputValue);
					break;
				case 'regex':
					if ($('fieldset.regex-table tr:last td:first input', sites[url]).val() != "")
						$('fieldset.regex-table a', sites[url]).click();

					$('fieldset.regex-table tr:last td:first input', sites[url]).val(inputValue);
					break;
				case 'result':
					if ($('fieldset.regex-table tr:last td:last input', sites[url]).val() != "")
						$('fieldset.regex-table a', sites[url]).click();

					$('fieldset.regex-table tr:last td:last input', sites[url]).val(inputValue);
					break;
				default:
					alert(inputType);
					break;
			}
		}

		$('#submit-form').click();
	}
	else
	{
		createNewBox();
	}
}

