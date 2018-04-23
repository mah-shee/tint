<?php //コンテンツ設定に必要な定数や関数
///////////////////////////////////////
// 外部リンク
///////////////////////////////////////

//外部リンクの開き方
define('OP_EXTERNAL_LINK_OPEN_TYPE', 'external_link_open_type');
if ( !function_exists( 'get_external_link_open_type' ) ):
function get_external_link_open_type(){
  return get_theme_option(OP_EXTERNAL_LINK_OPEN_TYPE, 'default');
}
endif;
if ( !function_exists( 'get_external_link_open_type_default' ) ):
function get_external_link_open_type_default(){
  return get_external_link_open_type() == 'default';
}
endif;

//外部リンクのフォロータイプ
define('OP_EXTERNAL_LINK_FOLLOW_TYPE', 'external_link_follow_type');
if ( !function_exists( 'get_external_link_follow_type' ) ):
function get_external_link_follow_type(){
  return get_theme_option(OP_EXTERNAL_LINK_FOLLOW_TYPE, 'default');
}
endif;
if ( !function_exists( 'get_external_link_follow_type_default' ) ):
function get_external_link_follow_type_default(){
  return get_external_link_follow_type() == 'default';
}
endif;

//noopener
define('OP_EXTERNAL_LINK_NOOPENER_ENABLE', 'external_link_noopener_enable');
if ( !function_exists( 'is_external_link_noopener_enable' ) ):
function is_external_link_noopener_enable(){
  return get_theme_option(OP_EXTERNAL_LINK_NOOPENER_ENABLE);
}
endif;

//noreferrer
define('OP_EXTERNAL_LINK_NOREFERRER_ENABLE', 'external_link_noreferrer_enable');
if ( !function_exists( 'is_external_link_noreferrer_enable' ) ):
function is_external_link_noreferrer_enable(){
  return get_theme_option(OP_EXTERNAL_LINK_NOREFERRER_ENABLE);
}
endif;

//external
define('OP_EXTERNAL_LINK_EXTERNAL_ENABLE', 'external_link_external_enable');
if ( !function_exists( 'is_external_link_external_enable' ) ):
function is_external_link_external_enable(){
  return get_theme_option(OP_EXTERNAL_LINK_EXTERNAL_ENABLE);
}
endif;

//外部リンクアイコン表示
define('OP_EXTERNAL_LINK_ICON_VISIBLE', 'external_link_icon_visible');
if ( !function_exists( 'is_external_link_icon_visible' ) ):
function is_external_link_icon_visible(){
  return get_theme_option(OP_EXTERNAL_LINK_ICON_VISIBLE);
}

endif;

//外部リンクアイコン
define('OP_EXTERNAL_LINK_ICON', 'external_link_icon');
if ( !function_exists( 'get_external_link_icon' ) ):
function get_external_link_icon(){
  return get_theme_option(OP_EXTERNAL_LINK_ICON, 'fa-share-square-o');
}
endif;

///////////////////////////////////////
// 内部リンク
///////////////////////////////////////

//内部リンクの開き方
define('OP_INTERNAL_LINK_OPEN_TYPE', 'internal_link_open_type');
if ( !function_exists( 'get_internal_link_open_type' ) ):
function get_internal_link_open_type(){
  return get_theme_option(OP_INTERNAL_LINK_OPEN_TYPE, 'default');
}
endif;
if ( !function_exists( 'get_internal_link_open_type_default' ) ):
function get_internal_link_open_type_default(){
  return get_internal_link_open_type() == 'default';
}
endif;

//内部リンクのフォロータイプ
define('OP_INTERNAL_LINK_FOLLOW_TYPE', 'internal_link_follow_type');
if ( !function_exists( 'get_internal_link_follow_type' ) ):
function get_internal_link_follow_type(){
  return get_theme_option(OP_INTERNAL_LINK_FOLLOW_TYPE, 'default');
}
endif;
if ( !function_exists( 'get_internal_link_follow_type_default' ) ):
function get_internal_link_follow_type_default(){
  return get_internal_link_follow_type() == 'default';
}
endif;

//noopener
define('OP_INTERNAL_LINK_NOOPENER_ENABLE', 'internal_link_noopener_enable');
if ( !function_exists( 'is_internal_link_noopener_enable' ) ):
function is_internal_link_noopener_enable(){
  return get_theme_option(OP_INTERNAL_LINK_NOOPENER_ENABLE);
}
endif;

//noreferrer
define('OP_INTERNAL_LINK_NOREFERRER_ENABLE', 'internal_link_noreferrer_enable');
if ( !function_exists( 'is_internal_link_noreferrer_enable' ) ):
function is_internal_link_noreferrer_enable(){
  return get_theme_option(OP_INTERNAL_LINK_NOREFERRER_ENABLE);
}
endif;

//内部リンクアイコン表示
define('OP_INTERNAL_LINK_ICON_VISIBLE', 'internal_link_icon_visible');
if ( !function_exists( 'is_internal_link_icon_visible' ) ):
function is_internal_link_icon_visible(){
  return get_theme_option(OP_INTERNAL_LINK_ICON_VISIBLE);
}

endif;

//内部リンクアイコン
define('OP_INTERNAL_LINK_ICON', 'internal_link_icon');
if ( !function_exists( 'get_internal_link_icon' ) ):
function get_internal_link_icon(){
  return get_theme_option(OP_INTERNAL_LINK_ICON, 'fa-share-square-o');
}
endif;

//レスポンシブテーブル
define('OP_RESPONSIVE_TABLE_ENABLE', 'responsive_table_enable');
if ( !function_exists( 'is_responsive_table_enable' ) ):
function is_responsive_table_enable(){
  return get_theme_option(OP_RESPONSIVE_TABLE_ENABLE);
}
endif;

//横スクロールレスポンシブテーブル用の要素の追加
if (is_responsive_table_enable()) {
  add_filter('the_content', 'add_responsive_table_tag');
}
if ( !function_exists( 'add_responsive_table_tag' ) ):
function add_responsive_table_tag($the_content) {
  $the_content = preg_replace('/<table/i', '<div class="scrollable-table"><table', $the_content);
  $the_content = preg_replace('/<\/table>/i', '</table></div>', $the_content);
  return $the_content;
}
endif;