<?php

// menghubungkan ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cek_trafict';
$conn = mysqli_connect($host, $username, $password, $database);


$language 	= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$encoding 	= $_SERVER['HTTP_ACCEPT_ENCODING'];
$referer 	= $_SERVER['HTTP_REFERER'];
$connection = $_SERVER['HTTP_CONNECTION'];

$slug =  "http" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 's' : '') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

   
// Mendapatkan IP pengunjung menggunakan getenv()
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP tidak dikenali';
    return $ipaddress;
}

// Ambil data user agent
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Cek jenis device
$is_mobile = false;
$is_tablet = false;
if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $user_agent) || preg_match('/tablet|ipad/i', $user_agent)) {
  $is_mobile = true;
  if (preg_match('/tablet|ipad/i', $user_agent)) {
    $is_tablet = true;
  }
}

// Cek jenis jaringan
$is_wifi = false;
if (preg_match('/wifi/i', $user_agent)) {
  $is_wifi = true;
}

// Ambil lokasi berdasarkan IP
@$ip = get_client_ip(); 
@$location = json_decode(file_get_contents('http://ipinfo.io/'.$ip.'/json'));

if($location!==""){
	// Mengakses nilai string di dalam objek stdClass
	@$city = $location->city;
	@$region = $location->region;
	@$country = $location->country;
}else{
	@$city = "";
	@$region = "";
	@$country = "";
}
$combine_location = $city.$region.$country;
$sql = "INSERT INTO traffic_data (slug, user_agent, is_mobile, is_tablet, is_wifi, ip_address, location, city, region, country, language, encoding, referer, connection)
VALUES ('$slug', '$user_agent', '$is_mobile', '$is_tablet', '$is_wifi', '$ip', '$combine_location', '$city', '$region', '$country','$language','$encoding','$referer','$connection')" ;

	if ($conn->query($sql) === TRUE) {
	  // echo "Data berhasil disimpan ke database";
	} else {
	  // echo "Error: " . $sql . "<br>" . $conn->error;
	}

}
