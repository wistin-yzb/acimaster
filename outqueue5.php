<?php
$redis = new redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth('admin888');
$redis->select('0');
$grouptime = $redis->lrange('grouptime5',0,-1);
if($grouptime[0]>time()){
	$redis->close();exit();
}

$list = $redis->lrange('groupsend5', 0, -1);
if ($list) {
    $i = 0;
    $len = $redis->lLen('groupsend5');
    while (true) {
        if ($i >= $len) {
	    $redis->lpop('grouptime5');
            $redis->close();
            file_put_contents('/usr/local/etc/outqueuecok5.txt', 1);
            @unlink('/usr/local/etc/groupdata5.txt');
            exit();
        }
        $openid = $redis->lpop('groupsend5');
        if ($openid) {
            //send-msg
            send_template_msg($openid);
        }
        $i++;
    }
} else {
    $redis->close();
}

/**
 * send template msg
 * @param $openid
 * @return int
 */
function send_template_msg($openid)
{
    if (!$openid) {
        return -1;
    }

    $opt_json = json_decode(file_get_contents('/usr/local/etc/groupdata5.txt'));
    $template_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$opt_json->access_token}";

    if ($opt_json->auto_getnum != 0) {
        $auto_ret = get_user_info($opt_json->access_token, $openid);
        $auto_json = json_decode($auto_ret);
        $prefix = '尊敬的';
        switch ($opt_json->auto_getnum) {
            case 1:
                $opt_json->first = str_replace("#", $prefix . $auto_json->nickname, $opt_json->first);
                break;
            case 2:
                $opt_json->keyword1 = $prefix . $auto_json->nickname;
                break;
            case 3:
                $opt_json->keyword2 = $prefix . $auto_json->nickname;
                break;
            case 4:
                $opt_json->keyword3 = $prefix . $auto_json->nickname;
                break;
            case 5:
                $opt_json->keyword4 = $prefix . $auto_json->nickname;
                break;
            case 6:
                $opt_json->keyword5 = $prefix . $auto_json->nickname;
                break;
        }
    }

    $post_arr = array(
        "touser" => $openid,
        "template_id" => $opt_json->temp_id,
        "url" => $opt_json->url,
        "data" => array(
            "first" => array(
                "value" => $opt_json->first,
                "color" => $opt_json->first_color
            ),
            "{$opt_json->key_field1}" => array(
                "value" => $opt_json->keyword1,
                "color" => $opt_json->keyword1_color
            ),
            "{$opt_json->key_field2}" => array(
                "value" => $opt_json->keyword2,
                "color" => $opt_json->keyword2_color
            ),
            "{$opt_json->key_field3}" => array(
                "value" => $opt_json->keyword3,
                "color" => $opt_json->keyword3_color
            ),
            "{$opt_json->key_field4}" => array(
                "value" => $opt_json->keyword4,
                "color" => $opt_json->keyword4_color
            ),
            "{$opt_json->key_field5}" => array(
                "value" => $opt_json->keyword5,
                "color" => $opt_json->keyword5_color
            ),
            "remark" => array(
                "value" => $opt_json->remark,
                "color" => $opt_json->remark_color
            ),
        ),
    );
    $post_json = json_encode($post_arr);    
    $ret = https_request($template_url, $post_json);    
}

/**
 * remote-post
 * @param $url
 * @param null $data
 * @return mixed
 */
function https_request($url, $data = NULL)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($data));
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/**
 * get-user_info
 * @param $access_token
 * @param $openid
 * @return int|mixed
 */
function get_user_info($access_token, $openid)
{
    if (!$access_token || !$openid) {
        return -1;
    }
    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
    return https_request($url);
}

?>
