<?php
class Balance
{
    public static $table_name = 'user_balances';
    public static function create_notification_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                user_id bigint(20) NOT NULL,
                balance decimal(10, 2) NOT NULL,
                PRIMARY KEY (user_id)
            ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    //Add balance 
    public static function add_user_balance($user_id, $new_balance)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        $data = array(
            'user_id' => $user_id,
            'balance' => $new_balance,
        );
        $format = array('%d', '%f');

        $add_balance = $wpdb->insert($table_name, $data, $format);

        return $add_balance;
    }

    // Функция для обновления баланса пользователя в таблице user_balances
    public static function update_user_balance($user_id, $new_balance)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        $update_balance = $wpdb->update(
            $table_name,
            array('balance' => $new_balance),
            array('user_id' => $user_id),
            array('%f'),
            array('%d')
        );

        return $update_balance;
    }

    // Функция для получения баланса пользователя из таблицы user_balances
    public static function get_user_balance($user_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        $query = $wpdb->prepare("SELECT balance FROM $table_name WHERE user_id = %d", $user_id);
        $balance = $wpdb->get_var($query);
        return floatval($balance);
    }
    // Функция для вычета средств с баланса пользователя
    public static function subtract_user_balance($user_id, $amount)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        $current_balance = self::get_user_balance($user_id);

        if ($current_balance >= $amount) {
            $new_balance = $current_balance - $amount;
            $update_balance = $wpdb->update(
                $table_name,
                array('balance' => $new_balance),
                array('user_id' => $user_id),
                array('%f'),
                array('%d')
            );

            if ($update_balance !== false) {
                return true;
            }
        }
        return false;
    }
}