<?php
// ユーザーエージェントを取得
$browser = $_SERVER['HTTP_USER_AGENT'];

// IEからアクセスした場合
if (strstr($browser, 'Trident') || strstr($browser, 'MSIE')) {
  // $ie_browser = $browser;
  $browser = 'ie_access';
}
