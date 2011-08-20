<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Flash CSRF Applet Demonstration</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" />

		<script type="text/javascript" src="main.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			google.load("jquery", "1.4.4");

			google.setOnLoadCallback(function() {
				initNewInputHandler();
				initNewUrlHandler();
				initMethodToggleHandler();
				initSubmitHandler();
				handleInitialSetup();
			});
		</script>
	</head>
	<body>
		<div id="container">
			<h1>Flash CSRF Applet Demonstration</h1>

			<div class="rounded-box info-box">
				<div class="img">
					<img src="http://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Information.svg/200px-Information.svg.png" alt="Info" />
				</div>
				<div class="info">
					<p>Jason Calvert, an employee at Whitehat Security, has built a similar tool.</p>
					<p><a href="csrf-alt.swf">His applet has been uploaded as an alternative to the system below.</a></p>
				</div>
				<div class="clear"></div>
			</div>

			<div id="submit-info">
				<div id="site-list">
					<div id="base-info" class="rounded-box">
						<p><strong>General Details:</strong></p>
						<p><strong>SWF URL:</strong> <input id="swf-url" type="text" value="csrf.swf" style="width: 300px" /></p>
						<p>If you're using a copy of the SWF that's hosted remotely, please change this value to the full web address for the SWF.</p>
						</fieldset>
					</div>
				</div>
				<div id="site-base" class="site-details rounded-box">
					<form action="#" method="post">
					<fieldset class="basic-info">
						<legend>Target Details:</legend>
						<table>
							<tr>
								<td><strong>Method:</strong></td>
								<td><select name="input[URL][method]"><option value="GET">GET</option><option value="POST">POST</option></select></td>
							</tr>
							<tr>
								<td><strong>URL:</strong></td>
								<td><input class="target-url" type="text" /></td>
							</tr>
							<tr class="post-body">
								<td><strong>POST Body:</strong></td>
								<td><textarea name="input[URL][data]"></textarea></td>
							</tr>
						</table>
					</fieldset>
					<fieldset class="header-table expandable-table">
						<legend>Headers:</legend>
						<table>
							<tr>
								<th class="left-col">Header Key</th>
								<th class="right-col">Header Value</th>
							</tr>
							<tr>
								<td class="left-col"><input name="input[URL][headerK][]" type="text" /></td>
								<td class="right-col"><input name="input[URL][headerV][]" type="text" /></td>
							</tr>
						</table>
						<p style="text-align: right"><a href="#">Add new header</a></p>
					</fieldset>
					<fieldset class="regex-table expandable-table">
						<legend>Response Parsing:</legend>
						<table>
							<tr>
								<th class="left-col">Regex</th>
								<th class="right-col">Result</th>
							</tr>
							<tr>
								<td class="left-col"><input name="input[URL][regex][]" type="text" /></td>
								<td class="right-col"><input name="input[URL][result][]" type="text" /></td>
							</tr>
						</table>
						<p style="text-align: right"><a href="#">Add new regex</a></p>
					</fieldset>
					</form>
				</div>
				<p style="text-align: right"><a href="#">Add new URL</a></p>

				<input id="submit-form" type="submit" value="Submit!" />
			</div>
			<div id="applet-display">
				<iframe name="applet-frame" scrolling="no"></iframe>
			</div>
			<div style="clear: both">&nbsp;</div>
		</div>
	</body>
</html>
