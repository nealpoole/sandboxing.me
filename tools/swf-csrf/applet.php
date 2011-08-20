<?php

$input = array();

// If we're being given input
if (isset($_REQUEST['input']) && is_array($_REQUEST['input']))
{
	$i = 0;

	// Input is an associative array, mapping URLs to another array
	foreach ($_REQUEST['input'] as $cur_url => $searches)
	{
		$input['url' . $i] = $cur_url;
		$input['method' . $i] = isset($searches['method']) && in_array($searches['method'], array('GET', 'POST')) ? $searches['method'] : 'GET';
		$input['data' . $i] = isset($searches['data']) ? urlencode($searches['data']) : '';

		// If we have our other array
		if (is_array($searches))
		{
			foreach (array('regex', 'result', 'headerK', 'headerV') as $key)
			{
				// If we have an array of regexes
				if (isset($searches[$key]) && is_array($searches[$key]))
				{
					$j = 0;

					// This is a numerically indexed array (or it should be), containing regexes
					foreach ($searches[$key] as $cur_item)
					{
						$input[$key . $i . '_' . $j] = urlencode($cur_item);
						++$j;
					}
				}
			}
		}

		++$i;
	}
}

$swf_url = 'csrf.swf';
if (isset($_REQUEST['swf_url']))
{
	if (strpos($_REQUEST['swf_url'], 'http://') === 0 || strpos($_REQUEST['swf_url'], 'https://') === 0)
		$swf_url = htmlspecialchars($_REQUEST['swf_url']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Flash CSRF Applet Demonstration</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
		body { margin: 0; padding: 0; }
		</style>
		<script type="text/javascript" src="swfobject.js"></script>
		<script type="text/javascript">
		var input = <?php echo json_encode($input); ?>;

		swfobject.embedSWF("<?php echo $swf_url ?>", "myContent", "500", "700", "9.0.0", false, input);
		</script>
	</head>
	<body>
		<div id="myContent">
			<h1>This tool requires JavaScript</h1>
			<p>Please enable JavaScript in your browser, and try again.</p>
		</div>
	</body>
</html>
