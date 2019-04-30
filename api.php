<?php
/*
 * @Author: yumusb
 * @LastEditors: yumusb
 * @Description: 
 * @Date: 2019-04-25 09:24:02
 * @LastEditTime: 2019-04-26 10:59:46
 */

include 'common.php';
function error($info = "ERROR")
{
    echo $info;
    exit();
}
function filter($keyword)
{
    $keyword = urldecode($keyword);
    if (is_numeric($keyword)) {
        error();
    }
    $blacklist = "韩国|车展|美女|范拍|真人秀|小姐|写真|自拍|美女|趣向|内衣|欧美|日韩|街拍";
    $encode = mb_detect_encoding("中国", array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
    if ($encode !== "UTF-8") {
        $blacklist = iconv($encode, "UTF-8//IGNORE", $blacklist);
    }
    if (preg_match("/$blacklist/", $keyword)) {
        error("BLACKLIST");
    } else {
        return $keyword;
    }
}
function get_movie($keyword)
{
    $url = WEBSITE . 'index.php?m=vod-search';

    $post = array("wd" => $keyword, "submit" => "search");

    $data =  curl_post($url, $post);
    $blacklist = "福利片|伦理片";
    $encode = mb_detect_encoding("中国", array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
    if ($encode !== "UTF-8") {
        $blacklist = iconv($encode, "UTF-8//IGNORE", $blacklist);
    }
    preg_match_all('/<a href="\/\?m=vod-detail-id-(\d+?).html" target="_blank">(.*?)<\/a>(?!.*('.$blacklist.'))/', $data, $res);
    $urls = $res[1];
    $titles = $res[2];
    $res = array();
    for ($i = 0; $i < count($urls); $i++) {
        $res[$titles[$i]] = $urls[$i];
    }
    return json_encode($res);
}
function play($id)
{
    $id = intval($id);
    $url = WEBSITE . "?m=vod-detail-id-{$id}.html";
    $html = curl_get($url);
    preg_match_all('/\/>(.*?.m3u8)</', $html, $urls);
    $urls = $urls[1];

    $res = array();
    foreach ($urls as $url) {
        $tmpurl = explode('$', $url)[1];
        $tmptitle = explode('$', $url)[0];
        $res[$tmptitle] = PLAYER . $tmpurl;
    }
    return json_encode($res);
}

if (isset($_SERVER['HTTP_REFERER'])) {
    if (stripos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) === false) {
        error("You kinding me");
    }
} else {
    error("f**K");
}

if (isset($_GET['do']) && isset($_GET['v'])) {
    $do = trim($_GET['do']);
    $v = trim($_GET['v']);
    switch ($do) {
        case "get":
            if ($keyword = filter($_GET['v'])) {
                echo get_movie($keyword);
            } else {
                error("EXCUSE ME??");
            }
            break;
        case "play":
            echo play($v);
            break;
        default:
            error();
    }
} else {
    error();
}
