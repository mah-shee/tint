<?php
//一覧ページへのURL
$list_url = AT_LIST_URL;
 ?>
<form name="form1" method="post" action="<?php echo $list_url; ?>" class="admin-settings">
  <?php
  $id = isset($_GET['id']) ? $_GET['id'] : null;

  if ($id) {
    $record = get_affiliate_tag($id);
    if (!$record) {
      //指定IDの関数テキストが存在しない場合は一覧にリダイレクト
      redirect_to_url($list_url);
    }

  }
  ?>
  <p><?php _e( '以下の内容を削除しますか？', THEME_NAME ) ?></p>

  <div class="at-confirm-wrap">
    <div class="at-confirm-title">
      <?php echo esc_html($record->title); ?>
    </div>
    <div class="at-confirm-text">
      <pre>
      <?php echo esc_html($record->text); ?>
      </pre>
    </div>
  </div>
  <div class="yes-back">
    <?php submit_button(__( '削除する', THEME_NAME )); ?>
    <p><a href="<?php echo $list_url; ?>"><?php _e( '削除しないで一覧に戻る', THEME_NAME ) ?></a></p>
  </div>

  <input type="hidden" name="action" value="delete">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  <input type="hidden" name="<?php echo HIDDEN_DELETE_FIELD_NAME; ?>" value="Y">
</form>