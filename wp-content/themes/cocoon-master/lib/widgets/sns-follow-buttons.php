<?php
///////////////////////////////////////////////////
//SNSフォローボタン
///////////////////////////////////////////////////
class SocialFollowWidgetItem extends WP_Widget {
  function __construct() {
    parent::__construct(
      'sns_follow_buttons',
      WIDGET_NAME_PREFIX.__( 'SNSフォローボタン', THEME_NAME ),
      array('description' => __( 'SNSサービスのフォローアイコンボタンを表示するウィジェットです。', THEME_NAME )),
      array( 'width' => 400, 'height' => 350 )
    );
  }
  function widget($args, $instance) {
    extract( $args );
    $title_popular = apply_filters( 'widget_title_social_follow', $instance['title_social_follow'] );
    $title_popular = apply_filters( 'widget_title', $title_popular, $instance, $this->id_base );
    echo $args['before_widget'];
    if ($title_popular !== null) {
      echo $args['before_title'];
      if ($title_popular) {
        echo $title_popular;
      } else {
        echo __( 'SNSフォローボタン', THEME_NAME );
      }
      echo $args['after_title'];
    }

    get_template_part('tmp/sns-follow-buttons'); //SNSフォローボタン
    echo $args['after_widget']; ?>
  <?php
  }
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title_social_follow'] = trim(strip_tags($new_instance['title_social_follow']));
      return $instance;
  }
  function form($instance) {
    if(empty($instance)){
      $instance = array(
        'title_social_follow' => null,
      );
    }
    $title_social_follow = esc_attr($instance['title_social_follow']);
    ?>
    <p>
       <label for="<?php echo $this->get_field_id('title_social_follow'); ?>">
        <?php _e( 'SNSフォローボタンのタイトル', THEME_NAME ) ?>
       </label>
       <input class="widefat" id="<?php echo $this->get_field_id('title_social_follow'); ?>" name="<?php echo $this->get_field_name('title_social_follow'); ?>" type="text" value="<?php echo $title_social_follow; ?>" />
    </p>
    <?php
  }
}
//add_action('widgets_init', create_function('', 'return register_widget("SocialFollowWidgetItem");'));
add_action('widgets_init', function(){register_widget('SocialFollowWidgetItem');});