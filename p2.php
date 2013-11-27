<?php
$ch1 = curl_init();
$ch2 = curl_init();
// 指定URL和适当的参数
curl_setopt($ch1, CURLOPT_URL, "http://shougeit.com/");
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_setopt($ch2, CURLOPT_URL, "http://www.zitiwu.com/");
curl_setopt($ch2, CURLOPT_HEADER, 0);
// 创建cURL批处理句柄
$mh = curl_multi_init();
// 加上前面两个资源句柄
curl_multi_add_handle($mh,$ch1);
curl_multi_add_handle($mh,$ch2);
// 预定义一个状态变量
$active = null;
// 执行批处理
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);
while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
}
// 关闭各个句柄
curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch2);
curl_multi_close($mh);

?>