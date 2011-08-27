<?php

define('SITE_ROOT', '../../');

class UTF8_Helper
{
	private static $utf8 = array(
		array('00000000'),
		array('11000000', '10000000'),
		array('11100000', '10000000', '10000000'),
		array('11110000', '10000000', '10000000', '10000000'),
		array('11111000', '10000000', '10000000', '10000000', '10000000'),
		array('11111100', '10000000', '10000000', '10000000', '10000000', '10000000')
	);

	static function generate_overlong_representations($chr)
	{
		return array_map(array('self', '_overlong_helper'), self::$utf8, array_fill(0, count(self::$utf8), $chr));
	}

	private function _overlong_helper($utf_bytes, $chr)
	{
		// Convert the binary strings into decimal, turn them into literal characters.
		$utf_bytes = array_map('chr', array_map('bindec', $utf_bytes));

		// The last octet is XORed with our character
		$utf_bytes[count($utf_bytes) - 1] = $chr | $utf_bytes[count($utf_bytes) - 1];

		// We map the results to the hex representations
		return array_map('bin2hex', $utf_bytes);
	}
}

require SITE_ROOT . 'header.php';

?>
			<h1>Overlong UTF-8 Encodings</h1>
			<table id="utf8-encodings" style="font-family: Verdana; font-size: 12px;">
				<thead>
					<tr>
						<th>Char</th>
						<th>Hex</th>
						<th>2 Bytes</th>
						<th>3 Bytes</th>
						<th>4 Bytes</th>
						<th>5 Bytes</th>
						<th>6 Bytes</th>
					</tr>
				</thead>
				<tbody>
<?php

for ($i = 0; $i <= 255; ++$i)
{
	$vals = UTF8_Helper::generate_overlong_representations(chr($i));

?>
					<tr>
						<td>&#x<?php echo dechex($i); ?>;</td>
<?php foreach ($vals as $cur_val): ?>
						<td>%<?php echo implode('%', $cur_val); ?></td>
<?php endforeach; ?>
					</tr>
<?php

}

?>
				</tbody>
			</table>
<?php require SITE_ROOT . 'footer.php'; ?>
