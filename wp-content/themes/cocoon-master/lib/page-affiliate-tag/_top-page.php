
<?php //オリジナル設定ページ
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
  if( isset($_POST[HIDDEN_DELETE_FIELD_NAME]) &&
    $_POST[HIDDEN_DELETE_FIELD_NAME] == 'Y' ){

    ///////////////////////////////////////
    // 内容の削除
    ///////////////////////////////////////
    require_once 'posts-delete.php';
  }
} else {
  if( isset($_POST[HIDDEN_FIELD_NAME]) &&
    $_POST[HIDDEN_FIELD_NAME] == 'Y' ){

    ///////////////////////////////////////
    // 内容の保存
    ///////////////////////////////////////
    require_once 'posts.php';
  }
}



///////////////////////////////////////
// 入力フォーム
///////////////////////////////////////
?>
<div class="wrap admin-settings">
<h1><?php _e( 'アフィリエイトタグ管理', THEME_NAME ) ?></h1>
    <!-- アフィリエイトタグ -->
    <div class="affiliate-tag metabox-holder">
      <div class="operation-buttons">
        <a href="<?php echo AT_LIST_URL; ?>"><?php _e( '一覧ページへ', THEME_NAME ) ?></a>
        <a href="<?php echo AT_NEW_URL; ?>"><?php _e( '新規追加', THEME_NAME ) ?></a>
      </div>

      <p><?php _e( 'アフィリエイトタグの一括管理を行います。ショートコードで何度でも使い回すことができます。', THEME_NAME ) ?></p>

      <?php //一覧リストの表示
      $action = isset($_GET['action']) ? $_GET['action'] : null;
      if ($action == 'delete') {
        require_once 'form-delete.php';
      } else {
        if (!isset($action)) {
          require_once 'list.php';
        } else {//入力フォームの表示
          require_once 'form.php';
        }
      }


      ?>
    </div><!-- /.metabox-holder -->
</div>