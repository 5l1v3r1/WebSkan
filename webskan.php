<?php
header("Location: http://www.google.com");
//Server Timezone & Scan Datetime
	$servertimezone = date_default_timezone_get();
	$skandatetime = date('d/m/Y h:i:s a', time());

	$servTZ = "Server Timezone: ".$servertimezone."\n";
    $skanDT = "Scan Date & Time: ".$skandatetime."\n";

//IP Grabbing - Internal|External
	$publicIP = file_get_contents("http://ipecho.net/plain");
    
	$namedhost = getHostByname(gethostname());
	//Private IP Ranges (IPv4)
	//10.0.0.0 to 10.255.255.255
	//172.16.0.0 to 172.31.255.255
	//192.168.0.0 to 192.168.255.255
	
    $grabIPs = "Hostname: ".$namedhost."\nExternal IP: ".$publicIP."\n";
    $host = $publicIP;
    
//Port Scanning
	$skanbanner = "\n***Scanning PORTS on IP: ".$host."***\nTCP Ports\n";

//Common TCP Ports
	$ports = array(1, 7, 9, 11, 13, 15, 17, 18, 19, 20, 21, 22, 23, 25, 37, 43, 49, 53, 70,71,72,73,74, 79, 80,81, 88, 90, 101, 102, 104, 105, 107, 108, 109, 110, 111, 113, 115, 117, 118, 119, 126, 135, 137, 139, 143, 144, 152, 153, 156, 158, 162, 170, 177, 179, 194, 201, 209, 210, 213, 218, 220, 259, 262, 264, 280, 300, 308, 311, 318, 350, 351, 356, 366, 369, 370, 371, 383, 384, 387, 388, 389, 399, 401, 427, 433, 434, 443, 444, 445, 464, 465, 475, 491, 497, 502, 504, 510, 512, 513, 514, 515, 520, 524, 525, 530, 532, 540, 542, 543, 544, 546, 547, 548, 550, 554, 556, 563, 564, 587, 591, 593, 601, 604, 625, 631, 635, 636,  639, 641, 643, 646, 647, 648, 651, 653, 654, 655, 657, 660, 666, 674, 688, 690, 691, 694, 695, 700, 701, 702, 706, 711, 712, 749, 751, 753, 754, 760, 782, 783, 800, 802, 808, 829, 830, 831, 832, 833, 843, 847, 848, 853, 860, 861, 862, 873, 888, 897, 898, 902, 903, 953, 981, 987, 989, 990, 991, 992, 993, 995, 101, 1023);

	foreach ($ports as $port)
	{
	ini_set('max_execution_time',0);
	$connection = @fsockopen($host, $port, $errno, $errstr, 2);
        
		if (is_resource($connection))
        	{
		$openports = "Port Open: ".$port."(".getservbyport($port, "tcp").")\n";

		fclose($connection);
		}

			else
			{
			$closedports = "Port Closed: ".$port."\n\n";
		}
	}
    
	$skanlog = fopen('skanlog.txt', 'a');
	fwrite($skanlog, $servTZ);
	fwrite($skanlog, $skanDT);
	fwrite($skanlog, $grabIPs);
	fwrite($skanlog, $skanbanner);
	fwrite($skanlog, $openports);
	fwrite($skanlog, $closedports);
	fclose($skanlog);
?>
