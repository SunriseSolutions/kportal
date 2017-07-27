<?php
define('CHUNK_SIZE', 1024 * 1024); // Size (in bytes) of tiles chunk

$secret = '20170727lethanhbinhahihihi';

# get file name
$fileParam = $_GET['f'];
if(empty($fileParam)) {
	header("HTTP/1.0 404 Not Found");
	die();
}
$fileNameExt = explode('.', $fileParam);
$fileName    = $fileNameExt[0];
$ext         = $fileNameExt[1];

if(empty($ext) || empty($fileName)) {
	header("HTTP/1.0 404 Not Found");
	die();
}

$hash = hash('md5', $fileName);

$root = 'data';
if( ! is_dir($root)) {
	mkdir($root);
}
$lev1 = substr($hash, 0, 1);
if( ! is_dir($root . '/' . $lev1)) {
	mkdir($root . '/' . $lev1);
}

$lev2 = substr($hash, 1, 2);
if( ! is_dir($root . '/' . $lev1 . '/' . $lev2)) {
	mkdir($root . '/' . $lev1 . '/' . $lev2);
}

$lev3 = substr($hash, 3, 3);
if( ! is_dir($root . '/' . $lev1 . '/' . $lev2 . '/' . $lev3)) {
	mkdir($root . '/' . $lev1 . '/' . $lev2 . '/' . $lev3);
}

$path = $root . '/' . $lev1 . '/' . $lev2 . '/' . $lev3;


//file type is image,video,audio,text,binary
// Create connection
//$con=mysqli_connect("localhost","root","","file_db");

// Check connection
//if (mysqli_connect_errno())
//  {
//  echo "Failed to connect to MySQL: " . mysqli_connect_error(); mysqli_close($con);exit(-1);
//  }
# assemble file path
$filePath = $path . '/' . $fileName . '.' . $ext;

if( ! file_exists($filePath)) {
	$fileServerUrl = 'http://file-server.local.com:81/kportal/web/app_dev.php/get-file-url/' . $fileName . '?bean-secret-key=' . $secret . '&ext=' . $ext;
	$fileUrl       = file_get_contents($fileServerUrl);
	
	if($fileUrl === '{404}') {
		header("HTTP/1.0 404 Not Found");
		die();
	} elseif($fileUrl === '{fuck-you}') {
		header("HTTP/1.0 404 Not Found");
		echo 'try again later';
		die();
	}
	
	set_time_limit(0);
//This is the file where we save the    information
	$fp = fopen($filePath, 'w+');

//Here is the file we are downloading, replace spaces with %20
	$ch = curl_init(str_replace(" ", "%20", $fileUrl));
	curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// get curl response
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	
};

$filesize = filesize($filePath);


$offset = 0;
$length = $filesize;

if(isset($_SERVER['HTTP_RANGE'])) {
	// if the HTTP_RANGE header is set we're dealing with partial content
	
	$partialContent = true;
	
	// find the requested range
	// this might be too simplistic, apparently the client can request
	// multiple ranges, which can become pretty complex, so ignore it for now
	preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
	
	$offset = intval($matches[1]);
	$length = (($matches[2]) ? intval($matches[2]) : $filesize) - $offset; //intval($matches[2]) - $offset;
	
	
	$file = fopen($filePath, 'r');

// seek to the requested offset, this is 0 if it's not a partial content request
	fseek($file, $offset);
	$data = fread($file, $length);
	fclose($file);
	
} else {
	$partialContent = false;
}


$ctype = mime_content_type($filePath);//'audio/mpeg';
//if($ctype === 'audio/mpeg') {
if($partialContent) {
	// output the right headers for partial content
	
	header('HTTP/1.1 206 Partial Content');
	
	header('Content-Range: bytes ' . $offset . '-' . ($offset + $length - 1) . '/' . $filesize);

// output the regular HTTP headers
	header('Content-Type: ' . $ctype);
	header("Cache-Control: public");
	header('Content-Length: ' . $filesize);
	header('Content-Disposition: inline; filename="' . $fileName . '.' . $ext . '"');
	header('Accept-Ranges: bytes');

// don't forget to send the data too
	print($data);
	exit();
}

// output the regular HTTP headers
header('Content-Type: ' . $ctype);
header("Cache-Control: public");
header('Content-Length: ' . $filesize);
header('Content-Disposition: inline; filename="' . $fileName . '.' . $ext . '"');
header('Accept-Ranges: bytes');

readfile_chunked($filePath);
exit();
//} else {
//	header('Content-Description: File Transfer');
//	header('Content-Type: ' . $ctype);
//	header('Accept-Ranges: bytes');


//	header('Expires: 0');
//	header('Cache-Control: must-revalidate');
//	header('Pragma: public');
//	header('Content-Length: ' . filesize($filePath));
//	readfile($filePath);
//	exit();
//}

/*	no partial range .blah blah blh
	if(isset($alias) && isset($row)) {
header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
 header("Content-Type: audio/mpeg");
 header("Content-Disposition: inline; filename=\"" . $fileName . "\"");
header("Content-Length: " . $fileSize);


$fh = fopen($file, "rb") or die("Could not open file: " .$file);



# output file
		while(!feof($fh))
		{
			# output file without bandwidth limiting
			print(fread($fh, filesize($file)));
		}
fclose($fh);
}else {echo 'null error';}
*/

//var_dump($row);var_dump($result);echo "SELECT * FROM files where file_code LIKE '%".$alias."%'";}

//readfile ($audio[$_GET['mp3']]);

// Read a file and display its content chunk by chunk
function readfile_chunked($filename, $retbytes = true) {
	$buffer = '';
	$cnt    = 0;
	$handle = fopen($filename, 'rb');
	
	if($handle === false) {
		return false;
	}
	
	while( ! feof($handle)) {
		$buffer = fread($handle, CHUNK_SIZE);
		echo $buffer;
		ob_flush();
		flush();
		
		if($retbytes) {
			$cnt += strlen($buffer);
		}
	}
	
	$status = fclose($handle);
	
	if($retbytes && $status) {
		return $cnt; // return num. bytes delivered like readfile() does.
	}
	
	return $status;
}

// Here goes your code for checking that the user is logged in
// ...
// ...

//if ($logged_in) {
//	$filename = 'path/to/your/file';
//	$mimetype = 'mime/type';
//	header('Content-Type: '.$mimetype );
//	readfile_chunked($filename);
//
//} else {
//	echo 'Tabatha says you haven\'t paid.';
//}
