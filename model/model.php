<?php
class model{

function otptsel($msisdn){
	$bahan = 'connection=sms&phone_number=%2B';
	$body = "$bahan$msisdn";
	$ctl = strlen($body);
	$header = array(
		'Accept: application/json', 
		'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
		'Accept-Encoding: gzip, deflate, br', 'X-NewRelic-ID: VQ8GVFVVChAEUlJRBAcOUQ==',
		'content-length: ' . $ctl,
		'User-Agent: Mozilla/5.0 (Linux; U; Android 4.4; xx-xx; SM-J110F Build/KTU84P) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.16 Chrome/33.0.0.0'
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://tdwidm.telkomsel.com/passwordless/start");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	$hasil = curl_exec($ch);
}


function generate($msisdn,$otp){
	$l = 'client_id=9yUwRUZirC0DXZyjMeQF4zCr6KO2R0Ub&connection=sms&grant_type=password&username=%2B';
	$l1 = "$msisdn&password=$otp";
	$l2 = '&scope=openid%20offline_access&device=string';
	$login3 = "$l$l1$l2";

	$ch = curl_init();
	$header = array(
		'Accept: application/json', 
		'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
		'Accept-Encoding: gzip, deflate, br', 'X-NewRelic-ID: VQ8GVFVVChAEUlJRBAcOUQ==',
		'content-length: 161',
		'User-Agent: Mozilla/5.0 (Linux; U; Android 4.4; xx-xx; SM-J110F Build/KTU84P) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.16 Chrome/33.0.0.0'
	);
		curl_setopt($ch, CURLOPT_URL, 'https://tdwidm.telkomsel.com/oauth/ro');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $login3);
		$hasil = curl_exec($ch);
		$json_a = json_decode($hasil, true);
		$token = $json_a['id_token'];
		return $token;
}

function login($token){
	$bod = "id_token=$token";
	$ch = curl_init();
	$header = array(
		'accept: application/json',
		'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
		'Content-Length: 292',
		'Connection: Keep-Alive',
		'Accept-Encoding: gzip',
		'User-Agent: Mozilla/5.0 (Linux; U; Android 4.4; xx-xx; SM-J110F Build/KTU84P) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.16 Chrome/33.0.0.0',
		'X-NewRelic-ID: VQ8GVFVVChAEUlJRBAcOUQ=='

	);
		curl_setopt($ch, CURLOPT_URL, 'https://tdwidm.telkomsel.com/tokeninfo');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bod);
		$hasil = curl_exec($ch);
}

function patchtsel($msisdn,$token){
	$bod = '{"msisdn":"'.$msisdn.'"}';
	$ch = curl_init();
	$header = array(
		'accept: application/json',
		"authorization: Bearer $token",
		'transactionid: A901190719214506938000000',
		'channelid: VMP',
		'Content-Type: application/json;charset=utf-8',
		'Content-Length: 26',
		'Connection: Keep-Alive',
		'Accept-Encoding: gzip',
		'User-Agent: Mozilla/5.0 (Linux; U; Android 4.4; xx-xx; SM-J110F Build/KTU84P) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.16 Chrome/33.0.0.0',
		'X-NewRelic-ID: VQ8GVFVVChAEUlJRBAcOUQ=='

	);
		curl_setopt($ch, CURLOPT_URL, "https://vmp.telkomsel.com/api/user/");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bod);
		$hasil = curl_exec($ch);
		$json_a = json_decode($hasil, true);
		$promottoken = $json_a['promotedToken'];
		return $promottoken;
}

function belipaket($id, $promottoken){
	$bod = '{"toBeSubscribedTo":false}';
	$ch = curl_init();
	$header = array(
		'accept: application/json',
		"authorization: Bearer $promottoken",
		'transactionid: A901190719192442969383440',
		'channelid: VMP',
		'Content-Type: application/json;charset=utf-8',
		'Content-Length: 26',
		'Connection: Keep-Alive',
		'Accept-Encoding: gzip',
		'User-Agent: Mozilla/5.0 (Linux; U; Android 4.4; xx-xx; SM-J110F Build/KTU84P) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.16 Chrome/33.0.0.0',
		'X-NewRelic-ID: VQ8GVFVVChAEUlJRBAcOUQ=='
	
	);
		curl_setopt($ch, CURLOPT_URL, "https://vmp.telkomsel.com/api/packages/$id");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bod);
		$hasil = curl_exec($ch);
		$json_a = json_decode($hasil, true);
		echo $json_a['message'];
}
}







?>