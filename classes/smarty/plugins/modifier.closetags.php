<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */

function smarty_modifier_closetags($content) {
   preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $content, $result);
    $openedtags = $result[1];
  preg_match_all('#</([a-z]+)>#iU', $content, $result);
 $closedtags = $result[1];
  $len_opened = count($openedtags);
  if (count($closedtags) == $len_opened) {
       return $content;
  }
  $openedtags = array_reverse($openedtags);
  for ($i=0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
         $content .= '</'.$openedtags[$i].'>';
       } else {
           unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
  }
  return $content;
}
?>