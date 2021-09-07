<?php
/*
Plugin Name: Catch Copy
Plugin URI: https://github.com/yudong0114/catchcopy
Description: キャッチコピー設定用のプラグイン
Author: yudong0114
Version: 1.0
Author URI: https://github.com/yudong0114
*/
class CatchCopy {

    /**
     * コンストラクタ
     */
    function __construct() {
        add_action('admin_menu', [$this, 'add_pages']);
    }

    /**
     * キャッチコピー設定の管理画面用ページの追加
     */
    function add_pages() {
        add_menu_page(
            'キャッチコピー設定',    // ページタイトル
            'キャッチコピー',       // サイドメニュー名
            'manage_options',    // プラグインの権限
            'catchcopy-setting', // 設定ページのスラッグ名
            [$this, 'catchcopy_option_page'], // プラグイン設定ページ表示時に実行する関数
            'dashicons-text',    // サイドメニューのアイコン
            80                   // メニューを表示する位置
        );
    }

    /**
     * キャッチコピー設定フォームの作成
     */
    function catchcopy_option_page() {
        // $_POST['catchcopy_options']が存在する場合保存
        if (isset($_POST['catchcopy_options'])) {
            // nonce用フォームパラメータを検証す
            check_admin_referer();
            // 入力された値を保存
            update_option('catchcopy_options', $_POST['catchcopy_options']);
?>
            <div class="updated fade">
                <p><strong><?php _e('キャッチコピーを保存しました！'); ?></strong></p>
            </div>
<?php   } ?>
        <div class="wrap">
            <h2>キャッチコピー設定</h2>
            <form action="" method="post">
                <?php
                // nonce用フォームパラメータを表示する
                wp_nonce_field();
                // 保存されたオプションを取得
                $opt = get_option('catchcopy_options');
                // 保存されたキャッチコピー(テキスト)を取得
                $catchcopy = isset($opt['text']) ? $opt['text'] : null;
                ?> 
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="inputtext">キャッチコピー</label></th>
                        <td><input name="catchcopy_options[text]" type="text" id="inputtext" value="<?php echo $catchcopy ?>" class="regular-text" /></td>
                    </tr>
                </table>
                <p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
            </form>
        </div>
        <?php
    }

    /**
     * 設定したキャッチコピーを取得するメソッド
     */
    function get_catchcopy() {
        // 保存されたオプションを取得
        $catchcopy = get_option('catchcopy_options');
        // 保存されたキャッチコピー(テキスト)を取得・return
        return isset($catchcopy['text']) ? $catchcopy['text'] : null;
    }
}

// インスタンスの生成
$catch_copy = new CatchCopy;