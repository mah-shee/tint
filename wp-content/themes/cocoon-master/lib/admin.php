<?php //管理画面関係の関数

//管理画面に読み込むリソースの設定
add_action('admin_print_styles', 'admin_print_styles_custom');
if ( !function_exists( 'admin_print_styles_custom' ) ):
function admin_print_styles_custom() {
  wp_enqueue_style( 'admin-style', get_template_directory_uri().'/css/admin.css' );
  wp_enqueue_style( 'font-awesome-style', FONT_AWESOME_CDN_URL );

  //カラーピッカー
  wp_enqueue_style( 'wp-color-picker' );

  //メディアアップローダの javascript API
  wp_enqueue_media();
  // wp_enqueue_script( 'media-widgets' );
  // wp_enqueue_script( 'media-upload');
  //_v("ha");

  //wp_enqueue_script( 'tab-js-jquery', 'https://code.jquery.com/jquery.min.js');

  //global $pagenow;
  //var_dump($pagenow);

  ///////////////////////////////////////
  // 管理画面でのJavaScript読み込み
  ///////////////////////////////////////
  //管理画面用での独自JavaScriptの読み込み
  wp_enqueue_script( 'admin-javascript', get_template_directory_uri() . '/js/admin-javascript.js', array( ), false, true );

  //投稿ページの場合
  if (is_admin_post_page()) {
    //投稿時に記事公開確認ダイアログ処理
    wp_enqueue_confirmation_before_publish();
  }


  if (is_admin_php_page()/* || is_widgets_php_page()*/) {
    //タブの読み込み
    wp_enqueue_script( 'tab-js-jquery', '//code.jquery.com/jquery.min.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'tab-js', get_template_directory_uri() . '/js/jquery.tabs.js', array( 'tab-js-jquery' ), false, true );
  }

  if (is_admin_php_page()/*$pagenow == 'admin.php'*/) {
    //設定変更CSSの読み込み
    //wp_add_css_custome_to_inline_style();
    //IcoMoonの呼び出し
    wp_enqueue_style( 'icomoon-style', get_template_directory_uri() . '/webfonts/icomoon/style.css' );
    $select_index = 0;
    if (isset($_POST['select_index'])) {
    $select_index = intval($_POST[SELECT_INDEX_NAME]);
    }
    $data = 'jQuery(document).ready( function() {
         tabify("#tabs").select( '.$select_index.' );
         });';
    wp_add_inline_script( 'tab-js', $data, 'after' ) ;
    //ソースコードハイライトリソースの読み込み
    wp_enqueue_highlight_js();
    //画像リンク拡大効果がLightboxのとき
    wp_enqueue_lightbox();
    //画像リンク拡大効果がLityのとき
    wp_enqueue_lity();
    //画像リンク拡大効果がbaguetteboxのとき
    wp_enqueue_baguettebox();
    //カルーセル用
    wp_enqueue_slick();
    //ツリー型モバイルボタン（iframeで読み込むので不要）
    //wp_enqueue_slicknav();


    //Google Fonts
    wp_enqueue_google_fonts();

    // wp_enqueue_script( 'wp-color-picker' );

    // //作成した javascript
    // wp_enqueue_script( 'mediauploader' );

    // ///////////////////////////////////
    // //ソースコードのハイライト表示
    // ///////////////////////////////////
    // if ( is_code_highlight_enable() ){
    //   echo '<link rel="stylesheet" href="'. get_highlight_js_css_url().'">'.PHP_EOL;
    //   echo '<script src="'.get_template_directory_uri().'/plugins/highlight-js/highlight.min.js"></script>'.PHP_EOL;
    //   echo '<script type="text/javascript">
    //     (function($){
    //      $("'.get_code_highlight_css_selector().'").each(function(i, block) {
    //       hljs.highlightBlock(block);
    //      });
    //     })(jQuery);
    //     </script>';
    // }
  }

  //echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/css/admin.css" />'.PHP_EOL;
  //echo '<style>.column-thumbnail{width:80px;}</style>'.PHP_EOL;
}
endif;

//メディアを挿入の初期表示を「この投稿へのアップロード」にする
// add_action( 'admin_footer-post-new.php', 'customize_initial_view_of_media_uploader' );
// add_action( 'admin_footer-post.php', 'customize_initial_view_of_media_uploader' );
if ( !function_exists( 'customize_initial_view_of_media_uploader' ) ):
function customize_initial_view_of_media_uploader() {
echo "<script type='text/javascript'>
 //<![CDATA[
jQuery(function($) {
    $('#wpcontent').ajaxSuccess(function() {
        $('select.attachment-filters [value=\"uploaded\"]').attr( 'selected', true ).parent().trigger('change');
    });
});
  //]]>
</script>";
}
endif;


//投稿記事一覧にアイキャッチ画像を表示
//カラムの挿入
add_filter( 'manage_posts_columns', 'customize_admin_manage_posts_columns' );
if ( !function_exists( 'customize_admin_manage_posts_columns' ) ):
function customize_admin_manage_posts_columns($columns) {
  $columns['thumbnail'] = __( 'アイキャッチ', THEME_NAME );
  return $columns;
}
endif;


//管理画面の記事一覧テーブルにサムネイルの挿入
add_action( 'manage_posts_custom_column', 'customize_admin_add_column', 10, 2 );
if ( !function_exists( 'customize_admin_add_column' ) ):
function customize_admin_add_column($column_name, $post_id) {
  if ( 'thumbnail' == $column_name) {
    //テーマで設定されているサムネイルを利用する場合
    $thum = get_the_post_thumbnail($post_id, 'thumb100', array( 'style'=>'width:75px;height:auto;' ));
    //Wordpressで設定されているサムネイル（小）を利用する場合
    //$thum = get_the_post_thumbnail($post_id, 'small', array( 'style'=>'width:75px;height:auto;' ));
  }
  if ( isset($thum) && $thum ) {
    echo $thum;
  }
}
endif;

//管理ツールバーにメニュー追加
if (is_admin_tool_menu_visible() && is_user_administrator()) {
  add_action('admin_bar_menu', 'customize_admin_bar_menu', 9999);
}
if ( !function_exists( 'customize_admin_bar_menu' ) ):
function customize_admin_bar_menu($wp_admin_bar){
  //バーにメニューを追加
  $title = sprintf(
    '<span class="ab-label">%s</span>',
    __( '管理メニュー', THEME_NAME )//親メニューラベル
  );
  $wp_admin_bar->add_menu(array(
    'id'  => 'dashboard_menu',
    'meta'  => array(),
    'title' => $title
  ));
  //サブメニューを追加
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-dashboard', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'ダッシュボード', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-singles', // 子メニューID
    'meta'   => array(),
    'title'  => __( '投稿一覧', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/edit.php') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-pages', // 子メニューID
    'meta'   => array(),
    'title'  => __( '固定ページ一覧', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/edit.php?post_type=page') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-medias', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'メディア一覧', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/upload.php') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-themes', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'テーマ', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/themes.php') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-customize', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'カスタマイズ', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/customize.php?return=' . esc_url(site_url('/wp-admin/themes.php'))) // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-widget', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'ウィジェット', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/widgets.php') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-nav-menus', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'メニュー', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/nav-menus.php') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-theme-editor', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'テーマの編集', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/theme-editor.php') // ページURL
  ));
  $wp_admin_bar->add_menu(array(
    'parent' => 'dashboard_menu', // 親メニューID
    'id'   => 'dashboard_menu-plugins', // 子メニューID
    'meta'   => array(),
    'title'  => __( 'プラグイン一覧', THEME_NAME ), // ラベル
    'href'   => site_url('/wp-admin/plugins.php') // ページURL
  ));
  if (current_user_can('manage_options')) {//管理者権限がある場合
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-theme-settings', // 子メニューID
      'meta'   => array(),
      'title'  => __( SETTING_NAME_TOP, THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=theme-settings') // ページURL
    ));
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-speech-balloon', // 子メニューID
      'meta'   => array(),
      'title'  => __( '吹き出し', THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=speech-balloon') // ページURL
    ));
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-theme-func-text', // 子メニューID
      'meta'   => array(),
      'title'  => __( 'テンプレート', THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=theme-func-text') // ページURL
    ));
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-theme-affiliate-tag', // 子メニューID
      'meta'   => array(),
      'title'  => __( 'アフィリエイトタグ', THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=theme-affiliate-tag') // ページURL
    ));
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-theme-ranking', // 子メニューID
      'meta'   => array(),
      'title'  => __( 'ランキング作成', THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=theme-ranking') // ページURL
    ));
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-theme-access', // 子メニューID
      'meta'   => array(),
      'title'  => __( 'アクセス集計', THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=theme-access') // ページURL
    ));
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-theme-speed-up', // 子メニューID
      'meta'   => array(),
      'title'  => __( '高速化', THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=theme-speed-up') // ページURL
    ));
    $wp_admin_bar->add_menu(array(
      'parent' => 'dashboard_menu', // 親メニューID
      'id'   => 'dashboard_menu-theme-backup', // 子メニューID
      'meta'   => array(),
      'title'  => __( 'バックアップ', THEME_NAME ), // ラベル
      'href'   => site_url('/wp-admin/admin.php?page=theme-backup') // ページURL
    ));
  }
}
endif;


// //記事公開前に確認アラートを出す
// if (is_confirmation_before_publish()) {
//   add_action('admin_print_scripts', 'publish_confirm_admin_print_scripts');
// }
// if ( !function_exists( 'publish_confirm_admin_print_scripts' ) ):
// function publish_confirm_admin_print_scripts() {
//   $post_text = __( '公開', THEME_NAME );
//   $confirm_text = __( '記事を公開してもよろしいですか？', THEME_NAME );
//   echo <<< EOM
// <script type="text/javascript">
// //console.log("id");
// window.onload = function() {
//   var id = document.getElementById('publish');
//   if (id.value.indexOf("$post_text", 0) != -1) {
//     id.onclick = publish_confirm;
//   }
// }
// function publish_confirm() {
//   if (window.confirm("$confirm_text")) {
//     return true;
//   } else {
//     var elements = document.getElementsByTagName('span');
//     for (var i = 0; i < elements.length; i++) {
//       var element = elements[i];
//       if (element.className.indexOf("spinner", 0) != -1) {
//         element.classList.remove('spinner');
//       }
//     }
//     document.getElementById('publish').classList.remove('button-primary-disabled');
//     document.getElementById('save-post').classList.remove('button-disabled');

//       return false;
//   }
// }
// </script>
// EOM;
// }
// endif;

//投稿一覧リストの上にタグフィルターと管理者フィルターを追加する
add_action('restrict_manage_posts', 'custmuize_restrict_manage_posts');
if ( !function_exists( 'custmuize_restrict_manage_posts' ) ):
function custmuize_restrict_manage_posts(){
  global $post_type, $tag;
  if ( is_object_in_taxonomy( $post_type, 'post_tag' ) ) {
  $dropdown_options = array(
    'show_option_all' => get_taxonomy( 'post_tag' )->labels->all_items,
    'hide_empty' => 0,
    'hierarchical' => 1,
    'show_count' => 0,
    'orderby' => 'name',
    'selected' => $tag,
    'name' => 'tag',
    'taxonomy' => 'post_tag',
    'value_field' => 'slug'
  );
  wp_dropdown_categories( $dropdown_options );
  }

  wp_dropdown_users(
  array(
    'show_option_all' => 'すべてのユーザー',
    'name' => 'author'
  )
  );
}
endif;

//投稿一覧で「全てのタグ」選択時は$_GET['tag']をセットしない
add_action('load-edit.php', 'custmuize_load_edit_php');
if ( !function_exists( 'custmuize_load_edit_php' ) ):
function custmuize_load_edit_php(){
  if (isset($_GET['tag']) && '0' === $_GET['tag']) {
  unset ($_GET['tag']);
  }
}
endif;

// // ビジュアルエディタにHTMLを直挿入するためのボタンを追加
// add_filter( 'mce_buttons', 'add_insert_html_button' );
// if ( !function_exists( 'add_insert_html_button' ) ):
// function add_insert_html_button( $buttons ) {
//   $buttons[] = 'button_insert_html';
//   return $buttons;
// }
// endif;

// //ビジュアルエディターにHTML挿入ボタン動作を行うJavaScriptを追加する
// add_filter( 'mce_external_plugins', 'add_insert_html_button_plugin' );
// if ( !function_exists( 'add_insert_html_button_plugin' ) ):
// function add_insert_html_button_plugin( $plugin_array ) {
//   $plugin_array['custom_button_script'] =  get_template_directory_uri() . "/js/button-insert-html.js";
//   return $plugin_array;
// }
// endif;


//投稿管理画面のカテゴリー選択にフィルタリング機能を付ける
add_action( 'admin_head-post-new.php', 'add_category_filter_form' );
add_action( 'admin_head-post.php', 'add_category_filter_form' );
if ( !function_exists( 'add_category_filter_form' ) ):
function add_category_filter_form() {
?>
<script type="text/javascript">
jQuery(function($) {
  function zenToHan(text) {
  return text.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
      return String.fromCharCode(s.charCodeAt(0) - 65248);
    });
  }

  function catFilter( header, list ) {
  var form  = $('<form>').attr({'class':'filterform', 'action':'#'}).css({'position':'absolute', 'top':'38px'}),
    input = $('<input>').attr({'class':'filterinput', 'type':'text', 'placeholder':'<?php _e( 'カテゴリー検索', THEME_NAME ) ?>' });
  $(form).append(input).appendTo(header);
  $(header).css({'padding-top':'42px'});
  $(input).change(function() {
    var filter = $(this).val();
    filter = zenToHan(filter).toLowerCase();
    if( filter ) {
    //ラベルテキストから検索文字の見つからなかった場合は非表示
    $(list).find('label').filter(
      function (index) {
      var labelText = zenToHan($(this).text()).toLowerCase();
      return labelText.indexOf(filter) == -1;
      }
    ).hide();
    //ラベルテキストから検索文字の見つかった場合は表示
    $(list).find('label').filter(
      function (index) {
      var labelText = zenToHan($(this).text()).toLowerCase();
      return labelText.indexOf(filter) != -1;
      }
    ).show();
    } else {
    $(list).find('label').show();
    }
    return false;
  })
  .keyup(function() {
    $(this).change();
  });
  }

  $(function() {
  catFilter( $('#category-all'), $('#categorychecklist') );
  });
});
</script>
<?php
}
endif;


//デフォルトの抜粋入力欄をビジュアルエディターにする
add_action( 'add_meta_boxes', array ( 'VisualEditorExcerpt', 'switch_boxes' ) );
if ( !class_exists( 'VisualEditorExcerpt' ) ):
class VisualEditorExcerpt{
  public static function switch_boxes()
  {
    if ( ! post_type_supports( $GLOBALS['post']->post_type, 'excerpt' ) )    {
      return;
    }

    remove_meta_box(
      'postexcerpt' // ID
    ,   ''      // スクリーン、空だと全ての投稿タイプをサポート
    ,   'normal'    // コンテキスト
    );

    add_meta_box(
      'postexcerpt2'   // Reusing just 'postexcerpt' doesn't work.
    ,   __( 'Excerpt' )  // タイトル
    ,   array ( __CLASS__, 'show' ) // 表示関数
    ,   null          // スクリーン
    ,   'normal'      // コンテキスト
    ,   'core'        // 優先度
    );
  }


  //メタボックスの出力
  public static function show( $post )  {
  ?>
    <label class="screen-reader-text" for="excerpt"><?php
    _e( 'Excerpt' )
    ?></label>
    <?php
    //デフォルト名の'excerpt'を使用
    wp_editor(
      self::unescape( $post->post_excerpt ),
      'excerpt',
      array (
      'textarea_rows' => 15
    ,   'media_buttons' => false
    ,   'teeny'     => true
    ,   'tinymce'     => true
      )
    );
  }

  //エスケープ解除
  public static function unescape( $str )  {
    return str_replace(
      array ( '&lt;', '&gt;', '&quot;', '&amp;', '&nbsp;', '&amp;nbsp;' )
    ,   array ( '<',  '>',  '"',    '&',   ' ', ' ' )
    ,   $str
    );
  }
}
endif;



//テーマの編集機能で編集できるファイルを追加する wp4.4以降
add_filter('wp_theme_editor_filetypes', 'wp_theme_editor_filetypes_custom');
if ( !function_exists( 'wp_theme_editor_filetypes_custom' ) ):
function wp_theme_editor_filetypes_custom($default_types){
  $default_types[] = 'js';
  $default_types[] = 'scss';
  return $default_types;
}
endif;


//ビジュアルエディターのクラス名に任意のclassを追加する
//add_filter( 'teeny_mce_before_init', 'abc' );
add_filter( 'tiny_mce_before_init', 'tiny_mce_before_init_custom' );
if ( !function_exists( 'tiny_mce_before_init_custom' ) ):
function tiny_mce_before_init_custom( $mceInit ) {
  //var_dump($mceInit );
  $mceInit['body_class'] .= ' main article';
  return $mceInit;
}
endif;

