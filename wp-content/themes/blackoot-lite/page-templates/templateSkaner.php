<?php
get_header();
get_template_part( 'part-title' );
?>
<div class="container" id="main-content">
    <div class="formSkaner">
        <form action="" method="post">
			<table style="width:100%">
				<tr>
					<td>IP address:</td>
					<td>Ports range:</td>
					<td>
					
					<label for="pluginsDetection">Plugins detection:</label>
					</td>
					<td></td>
				</tr>
				<tr>
					<td><input type="text" size="12" name="ipAddress" value="192.168.66.23"></td>
					<td><input type="number" style="width: 4em" name="portFrom" min="0" max="65535" step="1" value="20"> - <input type="number" style="width: 4em" name="portTo" min="0" max="65535" step="1" value="443"></td>
					<td><select id="pluginsDetection" name="pluginsDetection">
						<option value="passive">passive</option>
						<option value="mixed">mixed</option>
						<option value="aggressive">aggressive</option>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="nmapExtended"/>nmap - extended scan?</label></td>
					<td></td>
					<td><label for="pluginsVersionDetection">Plugins version detection:</label></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<select id="pluginsVersionDetection" name="pluginsVersionDetection">
						<option value="passive">passive</option>
						<option value="mixed">mixed</option>
						<option value="aggressive">aggressive</option>
						</select>
						
					</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
					<input type="checkbox" name="updateDB"/>wpscan - update DB?</label>
					</td>
					<td></td>
				</tr>

			</table>
			
			<br>
            <input type="submit">
        </form>
    </div>
    <div id="textAreaOutput">
		<textarea readonly rows="30" cols="40"><?php
		header('X-Accel-Buffering: no');

		$ipAddress = $_POST["ipAddress"];
		$portFrom = $_POST["portFrom"];
		$portTo = $_POST["portTo"];
		$pluginsDetection=$_POST["pluginsDetection"];
		$pluginsVersionDetection = $_POST["pluginsVersionDetection"];
		$updateDB = $_POST["updateDB"];
		$nmapExtended = $_POST["nmapExtended"];

		if (isset($ipAddress) and isset($portFrom) and isset($portTo))
		{
			$cmd = 
			"/var/www/inz/otherStuff/skrypt.sh '" . 
			escapeshellcmd($ipAddress) .
			"' '" .
			escapeshellcmd($portFrom) .
			"' '" .
			escapeshellcmd($portTo) .
			"'";

			if ($pluginsDetection == "passive")
			{
				$additionalFlagsWordpress = $additionalFlagsWordpress . " --plugins-detection passive"; //escapeshellcmd($aggressive)";
			}
			if ($pluginsDetection == "mixed")
			{
				$additionalFlagsWordpress = $additionalFlagsWordpress . " --plugins-detection mixed"; //escapeshellcmd($aggressive)";
			}
			if ($pluginsDetection == "aggressive")
			{
				$additionalFlagsWordpress = $additionalFlagsWordpress . " --plugins-detection aggressive"; //escapeshellcmd($aggressive)";
			}
			if ($pluginsVersionDetection == "passive")
			{
				$additionalFlagsWordpress = $additionalFlagsWordpress . " --plugins-version-detection passive"; //escapeshellcmd($aggressive)";
			}
			if ($pluginsVersionDetection == "mixed")
			{
				$additionalFlagsWordpress = $additionalFlagsWordpress . " --plugins-version-detection mixed"; //escapeshellcmd($aggressive)";
			}
			if ($pluginsVersionDetection == "aggressive")
			{
				$additionalFlagsWordpress = $additionalFlagsWordpress . " --plugins-version-detection aggressive"; //escapeshellcmd($aggressive)";
			}
			if ($updateDB == "on")
			{
				$additionalFlagsWordpress = $additionalFlagsWordpress . " --update"; //escapeshellcmd($aggressive)";
			}
			if ($nmapExtended == "on")
			{
				$additionalFlagsNmap = $additionalFlagsNmap . "-A"; //escapeshellcmd($aggressive)";
			}

			while (@ ob_end_flush()); // end all output buffers if any
			$cmd = $cmd . " '" . $additionalFlagsWordpress . "'" . " '" . $additionalFlagsNmap . "'";
			$proc = popen($cmd, 'r');
			while (!feof($proc))
			{
				echo fread($proc, 4096);
			 	@ flush();
			}
		}
		else
		{
			echo "Please pass a correct ip address or a domain name, and a correct port range";
		}
		?>
		</textarea>
    </div>
</div>
<?php
get_footer();
?>
