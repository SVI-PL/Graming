<?php

/**
 * Global Entity Layer
 *
 * Standard: Missing
 *
 * @package DUP_PRO
 * @subpackage classes/entities
 * @copyright (c) 2017, Snapcreek LLC
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 *
 * @todo Finish Docs
 */

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

use Duplicator\Libs\Snap\SnapIO;
use Duplicator\Libs\Snap\SnapWP;
use Duplicator\Libs\Snap\SnapUtil;
use Duplicator\Utils\Crypt\CryptBlowfish;

require_once(DUPLICATOR____PATH . '/classes/package/class.pack.installer.php');

abstract class DUP_PRO_Dropbox_Transfer_Mode
{
    const Unconfigured = -1;
    const Disabled     = 0;
    const cURL         = 1;
    const FOpen_URL    = 2;
}

abstract class DUP_PRO_Google_Drive_Transfer_Mode
{
    const Unconfigured  = -1;
    const Auto          = 0;
    const FOpen_URL     = 1;
}

abstract class DUP_PRO_Thread_Lock_Mode
{
    const Flock    = 0;
    const SQL_Lock = 1;
}

abstract class DUP_PRO_Sql_Lock_Check
{
    const Sql_Success = 1;
    const Sql_Fail    = -1;
}

abstract class DUP_PRO_Email_Build_Mode
{
    const No_Emails           = 0;
    const Email_On_Failure    = 1;
    const Email_On_All_Builds = 2;
}

abstract class DUP_PRO_JSON_Mode
{
    const PHP    = 0;
    const Custom = 1;
}

abstract class DUP_PRO_Archive_Build_Mode
{
    const Unconfigured = -1;
    const Shell_Exec   = 1;
    const ZipArchive   = 2;
    const DupArchive   = 3;
}

class DUP_PRO_Server_Load_Reduction
{
    const None  = 0;
    const A_Bit = 1;
    const More  = 2;
    const A_Lot = 3;

    public static function microseconds_from_reduction($reduction)
    {
        switch ($reduction) {
            case self::A_Bit:
                return 20;
            case self::More:
                return 100;
            case self::A_Lot:
                return 500;
            case self::None:
            default:
                return 0;
        }
    }
}

abstract class DUP_PRO_ZipArchive_Mode
{
    const Multithreaded = 0;
    const SingleThread  = 1;
}

abstract class DUP_PRO_PHPDump_Mode
{
    const Multithreaded = 0;
    const SingleThread  = 1;
}

class DUP_PRO_Global_Notices
{
    public $dupArchiveSwitch = true;
}

class DUP_PRO_Global_Entity extends DUP_PRO_JSON_Entity_Base
{
    const GLOBAL_NAME                   = 'dup_pro_global';
    const INSTALLER_NAME_MODE_WITH_HASH = 'withhash';
    const INSTALLER_NAME_MODE_SIMPLE    = 'simple';

    const CLEANUP_HOOK                  = 'dup_pro_cleanup_hook';
    const CLEANUP_INTERVAL_NAME         = 'dup_pro_custom_interval';
    const CLEANUP_FILE_TIME_DELAY       = 81000; // In seconds, 22.5 hours
    const CLEANUP_EMAIL_NOTICE_INTERVAL = 24; // In hours

    const CLEANUP_MODE_OFF  = 0;
    const CLEANUP_MODE_MAIL = 1;
    const CLEANUP_MODE_AUTO = 2;

    // Note: All user mode settings are set in ResetUserSettings()
    //GENERAL
    public $uninstall_settings; // no longer used
    public $uninstall_packages;  // no longer used
    public $uninstall_tables; // no longer used
    public $crypt                        = true;
    public $wpfront_integrate;
    //PACKAGES::Visual
    public $package_ui_created;
    //PACKAGES::Basic::Database
    public $package_mysqldump;
    public $package_mysqldump_path;
    public $package_phpdump_mode         = DUP_PRO_PHPDump_Mode::Multithreaded;
    public $package_php_chunking; // Not actively used but required for upgrade
    public $package_mysqldump_qrylimit   = DUP_PRO_Constants::DEFAULT_MYSQL_DUMP_CHUNK_SIZE;
    //PACKAGES::Basic::Archive
    public $archive_build_mode           = DUP_PRO_Archive_Build_Mode::Unconfigured;
    public $archive_compression          = true;
    public $ziparchive_validation;
    public $ziparchive_mode;
    public $ziparchive_chunk_size_in_mb  = DUP_PRO_Constants::DEFAULT_ZIP_ARCHIVE_CHUNK;
    public $homepath_as_abspath          = false;
    //Schedules
    public $archive_build_mode_schedule  = DUP_PRO_Archive_Build_Mode::Unconfigured; // required to be pre-set to upgrade logic works
    public $archive_compression_schedule = true;
    //PACKAGES::Basic::Processing
    public $server_load_reduction;
    public $max_package_runtime_in_min   = DUP_PRO_Constants::DEFAULT_MAX_PACKAGE_RUNTIME_IN_MIN;
    public $php_max_worker_time_in_sec   = DUP_PRO_Constants::DEFAULT_MAX_WORKER_TIME;
    //PACKAGES::Basic::Cleanup
    public $cleanup_mode                 = self::CLEANUP_MODE_OFF;
    public $cleanup_email                = '';
    public $auto_cleanup_hours           = 24;
    //PACKAGES::Adanced
    public $lock_mode;
    public $json_mode;
    public $ajax_protocol;
    public $custom_ajax_url;
    public $clientside_kickoff;
    public $basic_auth_enabled;
    public $basic_auth_user;  // Not actively used but required for upgrade
    public $basic_auth_password;
    public $installer_name_mode          = self::INSTALLER_NAME_MODE_SIMPLE;
    public $installer_base_name          = DUP_PRO_Installer::DEFAULT_INSTALLER_FILE_NAME_WITHOUT_HASH;
    public $chunk_size                   = 2048;
    public $skip_archive_scan            = false;
    //SCHEDULES
    public $send_email_on_build_mode;
    public $notification_email_address;
    //STORAGE
    public $storage_htaccess_off;
    public $max_storage_retries;
    public $max_default_store_files;
    public $purge_default_package_record;
    public $dropbox_upload_chunksize_in_kb;
    public $dropbox_transfer_mode;
    public $gdrive_upload_chunksize_in_kb;  // Not exposed through the UI (yet)
    public $gdrive_transfer_mode = DUP_PRO_Google_Drive_Transfer_Mode::Auto;
    public $s3_upload_part_size_in_kb;
    public $onedrive_upload_chunksize_in_kb;
    public $manual_mode_storage_ids;
    //LICENSING
    public $license_status;
    public $license_expiration_time;
    public $license_no_activations_left;
    public $license_key_visible;
    public $lkp; // Not actively used but required for upgrade
    public $license_limit;
    //UPDATE CACHING
    public $last_edd_api_response;
    public $last_edd_api_timestamp;
    public $last_system_check_timestamp;
    public $initial_activation_timestamp;
    // Storage SSL
    public $ssl_useservercerts           = true;
    public $ssl_disableverify            = true;
    // Import
    public $import_chunk_size            = DUPLICATOR_PRO_DEFAULT_CHUNK_UPLOAD_SIZE; // in KB, 0 no chunk
    public $import_custom_path           = '';
    public $ipv4_only;
    //DEBUG
    public $debug_on;
    public $trace_profiler_on;
    // Unhook third party JS/CSS
    public $unhook_third_party_js;
    public $unhook_third_party_css;
    //PROFILES
    public $profile_idea;
    public $profile_beta;
    public $dupHidePackagesGiftFeatures;

    public static function initialize_plugin_data()
    {
        $globals = parent::get_by_type(get_class());

        if (count($globals) == 0) {
            update_option('duplicator_pro_reset_user_settings_required', 1);
            DUP_PRO_Log::trace("WARNING: Trouble retrieving user settings. The user settings will be reset during plugin initialization.");
            $global = new DUP_PRO_Global_Entity();

            $global->InitializeSystemSettings();
            // called from admin_init based on the `duplicator_pro_reset_user_settings_required` option flag
            // $global->ResetUserSettings();
            // Default local selected by default
            array_push($global->manual_mode_storage_ids, -2);

            $global->save();
        }
    }

    public function InitializeSystemSettings()
    {
        //STORAGE
        $this->manual_mode_storage_ids = array();

        //LICENSING
        $this->license_status              = Duplicator\Addons\ProBase\License\License::STATUS_UNKNOWN;
        $this->license_expiration_time     = time() - 10;  // Ensure it expires right away
        $this->license_no_activations_left = false;
        $this->license_key_visible         = true;
        $this->lkp                         = ''; // Not actively used but required for upgrade
        $this->license_limit               = -1;

        //UPDATE CACHING
        $this->last_edd_api_response        = null;
        $this->last_edd_api_timestamp       = 0;
        $this->last_system_check_timestamp  = 0;
        $this->initial_activation_timestamp = 0;
    }

    // Resets to defaults
    public function ResetUserSettings()
    {
        //GENERAL
        $this->uninstall_settings = false;
        $this->uninstall_packages = false;
        $this->uninstall_tables   = true;
        $this->wpfront_integrate  = false;

        //PACKAGES::Visual
        $this->package_ui_created = 1;

        //PACKAGES::Basic::Database
        $this->package_mysqldump          = false;
        $this->package_mysqldump_qrylimit = DUP_PRO_Constants::DEFAULT_MYSQL_DUMP_CHUNK_SIZE;
        $this->package_phpdump_mode       = DUP_PRO_PHPDump_Mode::Multithreaded;
        $this->package_mysqldump_path     = '';

        //PACKAGES::Basic::Archive
        $this->archive_build_mode          = DUP_PRO_Archive_Build_Mode::Unconfigured;
        $this->archive_compression         = true;  // TODO: PHP 7 allows ZipArchive to be set to Store - implement later
        $this->ziparchive_validation       = false;
        $this->ziparchive_mode             = DUP_PRO_ZipArchive_Mode::Multithreaded;
        $this->ziparchive_chunk_size_in_mb = DUP_PRO_Constants::DEFAULT_ZIP_ARCHIVE_CHUNK;
        $this->homepath_as_abspath         = false;

        $this->archive_build_mode_schedule  = DUP_PRO_Archive_Build_Mode::Unconfigured;
        $this->archive_compression_schedule = true;

        //PACKAGES::Basic::Processing
        $this->server_load_reduction      = DUP_PRO_Server_Load_Reduction::None;
        $this->max_package_runtime_in_min = DUP_PRO_Constants::DEFAULT_MAX_PACKAGE_RUNTIME_IN_MIN;
        $this->php_max_worker_time_in_sec = DUP_PRO_Constants::DEFAULT_MAX_WORKER_TIME;

        //PACKAGES::Basic::Cleanup
        $this->cleanup_mode               = self::CLEANUP_MODE_OFF;
        $this->cleanup_email              = get_option('admin_email');
        $this->auto_cleanup_hours         = 24;

        //PACKAGES::Advanced
        $this->lock_mode                 = self::get_lock_type();
        $this->json_mode                 = DUP_PRO_JSON_Mode::PHP;
        $this->ajax_protocol             = self::get_ajax_protocol();
        $this->custom_ajax_url           = "";
        $this->clientside_kickoff        = false;
        $this->basic_auth_enabled        = false;
        $this->basic_auth_user           = '';  // Not actively used but required for upgrade
        $this->basic_auth_password       = '';
        $this->installer_name_mode       = self::INSTALLER_NAME_MODE_SIMPLE;
        $this->installer_base_name       = DUP_PRO_Installer::DEFAULT_INSTALLER_FILE_NAME_WITHOUT_HASH;
        $this->chunk_size                = 2048;
        $this->skip_archive_scan         = false;

        //SCHEDULES
        $this->send_email_on_build_mode   = DUP_PRO_Email_Build_Mode::Email_On_Failure;
        $this->notification_email_address = '';

        //STORAGE
        $this->storage_htaccess_off            = false;
        $this->max_storage_retries             = 10;
        $this->max_default_store_files         = 20;
        $this->purge_default_package_record    = false;
        $this->dropbox_upload_chunksize_in_kb  = 2000;
        $this->dropbox_transfer_mode           = DUP_PRO_Dropbox_Transfer_Mode::Unconfigured;
        $this->gdrive_transfer_mode            = DUP_PRO_Google_Drive_Transfer_Mode::Auto;
        $this->gdrive_upload_chunksize_in_kb   = 1024;
        $this->s3_upload_part_size_in_kb       = 6000;
        $this->onedrive_upload_chunksize_in_kb = DUPLICATOR_PRO_ONEDRIVE_UPLOAD_CHUNK_DEFAULT_SIZE_IN_KB;

        $this->import_chunk_size = DUPLICATOR_PRO_DEFAULT_CHUNK_UPLOAD_SIZE;
        $this->import_custom_path = '';

        $this->ssl_useservercerts = true;
        $this->ssl_disableverify  = true;
        $this->ipv4_only          = false;

        //DEBUG
        $this->debug_on          = false;
        $this->trace_profiler_on = false;

        // Unhook third party JS/CSS
        $this->unhook_third_party_js  = false;
        $this->unhook_third_party_css = false;

        //ADVANCED
        $this->profile_idea = false;
        $this->profile_beta = false;

        // MISC
        $this->dupHidePackagesGiftFeatures = !DUPLICATOR_PRO_GIFT_THIS_RELEASE;

        $this->notices = new DUP_PRO_Global_Notices();

        $max_execution_time = ini_get("max_execution_time");

        if (empty($max_execution_time) || ($max_execution_time == 0) || ($max_execution_time == -1)) {
            $max_execution_time = 30;
        }

        // Default is just a bit under the .7 max
        $this->php_max_worker_time_in_sec = min(
            ((int) (0.7 * (float) $max_execution_time)),
            DUP_PRO_Constants::DEFAULT_MAX_WORKER_TIME
        );

        $storages = DUP_PRO_Storage_Entity::get_all();
        $sglobal  = DUP_PRO_Secure_Global_Entity::getInstance();

        $test_str      = 'aaa';
        $encrypted_str = CryptBlowfish::encrypt($test_str);
        $decrypted_str = CryptBlowfish::decrypt($encrypted_str);
        $this->crypt   = ($test_str == $decrypted_str) ? true : false;

        $this->set_build_mode();

        foreach ($storages as $storage) {
            $storage->save();
        }
        $sglobal->save();

        $this->custom_ajax_url = admin_url('admin-ajax.php', 'http');
    }

    public static function get_ajax_protocol()
    {
        return strtolower(parse_url(network_admin_url(), PHP_URL_SCHEME));
    }

    // TODO: Rework this to test proper operation of File locking - suspect a timeout in sql locking could cause problems so auto-setting to sql lock may cause issues
    public static function get_lock_type($sslverify = true)
    {
        $lock_type = DUP_PRO_Thread_Lock_Mode::Flock;
        $nonce     = wp_create_nonce('duplicator_pro_try_to_lock_test_sql');

        if (DUP_PRO_U::getSqlLock(DUPLICATOR_PRO_TEST_SQL_LOCK_NAME)) {
            $url      = admin_url('admin-ajax.php?action=duplicator_pro_try_to_lock_test_sql&nonce=' . $nonce);
            $args     = array(
                'timeout'   => 12,
                'method'    => 'POST',
                'sslverify' => $sslverify,
            );
            $res      = wp_remote_request($url, $args);
            $res_code = wp_remote_retrieve_response_code($res);
            if (!is_wp_error($res) && 200 == $res_code) {
                $body = wp_remote_retrieve_body($res);
                // Getting new sql lock fail (means SQL lock is working file)
                if ($body == DUP_PRO_Sql_Lock_Check::Sql_Fail) {
                    $lock_type = DUP_PRO_Thread_Lock_Mode::SQL_Lock;
                }
            } elseif (is_wp_error($res)) {
                $wp_error  = $res->get_error_message();
                $error_msg = 'Could not check system for sql lock support. wp_remote_request failed. Error: ' . $wp_error;
                DUP_PRO_Log::trace($error_msg);
                error_log($error_msg);
                if ($sslverify && false !== stripos($wp_error, 'SSL certificate')) {
                    $error_msg = 'Trying again to get lock type with disabling sslverify';
                    DUP_PRO_Log::trace($error_msg);
                    error_log($error_msg);
                    return self::get_lock_type(false);
                }
            } else {
                $res_message = wp_remote_retrieve_response_message($res);
                $error_msg   = 'Could not check system for sql lock support. Bad response status code. Response code:' . $res_code . ', Response message: ' . $res_message;
                DUP_PRO_Log::trace($error_msg);
                error_log($error_msg);
            }
        }


        DUP_PRO_Log::trace("Lock type auto set to {$lock_type}");
        DUP_PRO_U::releaseSqlLock(DUPLICATOR_PRO_TEST_SQL_LOCK_NAME);

        return $lock_type;
    }

    public function set_from_data($global_data)
    {
        //GENERAL
        $this->uninstall_settings = $global_data->uninstall_settings;
        $this->uninstall_packages = $global_data->uninstall_packages;
        $this->uninstall_tables   = $global_data->uninstall_tables;
        $this->wpfront_integrate  = $global_data->wpfront_integrate;

        //PACKAGES::Basic
        $this->package_mysqldump          = $global_data->package_mysqldump;
        $this->package_mysqldump_path     = $global_data->package_mysqldump_path;
        $this->package_mysqldump_qrylimit = $global_data->package_mysqldump_qrylimit;

        $this->archive_build_mode          = $global_data->archive_build_mode;
        $this->archive_compression         = $global_data->archive_compression;  // TODO: PHP 7 allows ZipArchive to be set to Store - implement later
        $this->ziparchive_chunk_size_in_mb = $global_data->ziparchive_chunk_size_in_mb;
        $this->ziparchive_mode             = $global_data->ziparchive_mode;
        $this->homepath_as_abspath         = $global_data->homepath_as_abspath;

        $this->archive_build_mode_schedule  = $global_data->archive_build_mode_schedule;
        $this->archive_compression_schedule = $global_data->archive_compression_schedule;

        $this->server_load_reduction      = $global_data->server_load_reduction;
        $this->max_package_runtime_in_min = $global_data->max_package_runtime_in_min;
        $this->php_max_worker_time_in_sec = $global_data->php_max_worker_time_in_sec;

        $this->cleanup_mode               = $global_data->cleanup_mode;
        $this->cleanup_email              = $global_data->cleanup_email;
        $this->auto_cleanup_hours         = $global_data->auto_cleanup_hours;

        //PACKAGES::Adanced
        $this->lock_mode           = $global_data->lock_mode;
        $this->json_mode           = $global_data->json_mode;
        $this->ajax_protocol       = $global_data->ajax_protocol;
        $this->custom_ajax_url     = $global_data->custom_ajax_url;
        $this->clientside_kickoff  = $global_data->clientside_kickoff;
        $this->basic_auth_enabled  = $global_data->basic_auth_enabled;
        $this->basic_auth_user     = $global_data->basic_auth_user;
        $this->installer_name_mode = $global_data->installer_name_mode;
        $this->installer_base_name = $global_data->installer_base_name;
        $this->chunk_size          = $global_data->chunk_size;
        $this->skip_archive_scan   = $global_data->skip_archive_scan;
        $this->ssl_useservercerts  = isset($global_data->ssl_useservercerts) ? $global_data->ssl_useservercerts : true;
        $this->ssl_disableverify   = isset($global_data->ssl_disableverify) ? $global_data->ssl_disableverify : true;
        $this->ipv4_only           = isset($global_data->ipv4_only) ? $global_data->ipv4_only : false;
        $this->import_chunk_size   = $global_data->import_chunk_size;
        $this->import_custom_path  = $global_data->import_custom_path;

        //SCHEDULES
        $this->send_email_on_build_mode   = $global_data->send_email_on_build_mode;
        $this->notification_email_address = $global_data->notification_email_address;

        //STORAGE
        $this->storage_htaccess_off            = $global_data->storage_htaccess_off;
        $this->max_storage_retries             = $global_data->max_storage_retries;
        $this->max_default_store_files         = intval($global_data->max_default_store_files);
        $this->purge_default_package_record    = $global_data->purge_default_package_record;
        $this->dropbox_upload_chunksize_in_kb  = $global_data->dropbox_upload_chunksize_in_kb;
        $this->dropbox_transfer_mode           = $global_data->dropbox_transfer_mode;
        $this->gdrive_transfer_mode            = $global_data->gdrive_transfer_mode;
        $this->gdrive_upload_chunksize_in_kb   = $global_data->gdrive_upload_chunksize_in_kb;  // Not exposed through the UI (yet)
        $this->s3_upload_part_size_in_kb       = $global_data->s3_upload_part_size_in_kb;
        $this->onedrive_upload_chunksize_in_kb = $global_data->onedrive_upload_chunksize_in_kb;
        $this->manual_mode_storage_ids         = $global_data->manual_mode_storage_ids;

        //LICENSING
        $this->license_status              = Duplicator\Addons\ProBase\License\License::STATUS_UNKNOWN;
        $this->license_expiration_time     = 0;
        $this->license_no_activations_left = false;
        $this->license_key_visible         = $global_data->license_key_visible;

        //UPDATE CACHING
        $this->last_edd_api_response  = null;
        $this->last_edd_api_timestamp = 0;

        //MISC - SOME SHOULD BE IN SYSTEM GLOBAL
        $this->last_system_check_timestamp  = 0;
        $this->initial_activation_timestamp = 0;

        //DEBUG
        $this->debug_on          = $global_data->debug_on;
        $this->trace_profiler_on = $global_data->trace_profiler_on;

        // Unhook third party JS/CSS
        $this->unhook_third_party_js  = $global_data->unhook_third_party_js;
        $this->unhook_third_party_css = $global_data->unhook_third_party_css;

        //ADVANCED
        $this->profile_idea = $global_data->profile_idea;
        $this->profile_beta = $global_data->profile_beta;
    }

    /**
     * Check if build mode is available
     *
     * @param int $buildMode build mode constant
     *
     * @return bool
     */
    public static function isBuildModeAvaiable($buildMode)
    {
        switch ($buildMode) {
            case DUP_PRO_Archive_Build_Mode::Unconfigured:
                return false;
            case DUP_PRO_Archive_Build_Mode::Shell_Exec:
                return (DUP_PRO_Zip_U::getShellExecZipPath() != null);
            case DUP_PRO_Archive_Build_Mode::ZipArchive:
                return apply_filters('duplicator_pro_is_ziparchive_available', class_exists('ZipArchive'));
            case DUP_PRO_Archive_Build_Mode::DupArchive:
                return true;
            default:
                throw new Exception('Invalid engine');
        }
    }

    /**
     * Return package build mode
     *
     * @return int Return enum DUP_PRO_Archive_Build_Mode
     */
    public function getBuildMode()
    {
        $archive_build_mode = $this->archive_build_mode;

        switch ($archive_build_mode) {
            case DUP_PRO_Archive_Build_Mode::Unconfigured:
                if (self::isBuildModeAvaiable(DUP_PRO_Archive_Build_Mode::Shell_Exec)) {
                    $archive_build_mode = DUP_PRO_Archive_Build_Mode::Shell_Exec;
                } elseif (self::isBuildModeAvaiable(DUP_PRO_Archive_Build_Mode::ZipArchive)) {
                    $archive_build_mode = DUP_PRO_Archive_Build_Mode::ZipArchive;
                } else {
                    $archive_build_mode = DUP_PRO_Archive_Build_Mode::DupArchive;
                }
                break;
            case DUP_PRO_Archive_Build_Mode::Shell_Exec:
                if (!self::isBuildModeAvaiable(DUP_PRO_Archive_Build_Mode::Shell_Exec)) {
                    if (self::isBuildModeAvaiable(DUP_PRO_Archive_Build_Mode::ZipArchive)) {
                        $archive_build_mode = DUP_PRO_Archive_Build_Mode::ZipArchive;
                    } else {
                        $archive_build_mode = DUP_PRO_Archive_Build_Mode::DupArchive;
                    }
                }
                break;
            case DUP_PRO_Archive_Build_Mode::ZipArchive:
                if (!self::isBuildModeAvaiable(DUP_PRO_Archive_Build_Mode::ZipArchive)) {
                    if (self::isBuildModeAvaiable(DUP_PRO_Archive_Build_Mode::Shell_Exec)) {
                        $archive_build_mode = DUP_PRO_Archive_Build_Mode::Shell_Exec;
                    } else {
                        $archive_build_mode = DUP_PRO_Archive_Build_Mode::DupArchive;
                    }
                }
                break;
            case DUP_PRO_Archive_Build_Mode::DupArchive:
                break;
            default:
                throw new Exception('Invalid engine');
        }
        return $archive_build_mode;
    }

    /**
     * Selt build mode and return it
     *
     * @return int Return enum DUP_PRO_Archive_Build_Mode
     */
    public function set_build_mode()
    {
        $archive_build_mode = $this->getBuildMode();

        $this->archive_build_mode = apply_filters('duplicator_pro_default_archive_build_mode', $archive_build_mode);
        return $this->archive_build_mode;
    }

    /**
     *
     * @return int microsenconds
     */
    public function getMicrosecLoadReduction()
    {
        return DUP_PRO_Server_Load_Reduction::microseconds_from_reduction($this->server_load_reduction);
    }

    /**
     * set db mode ant all related params.
     * check mysqldump
     *
     * @param null|string $dbMode               if null get INPUT_POST
     * @param null|int $phpDumpMode             if null get INPUT_POST
     * @param null|int $dbPhpQueryLimit         if null get INPUT_POST
     * @param null|string $packageMysqldumpPath if null get INPUT_POST
     */
    public function setDbMode($dbMode = null, $phpDumpMode = null, $dbPhpQueryLimit = null, $packageMysqldumpPath = null, $dbMysqlDumpQueryLimit = null)
    {
        //DATABASE
        $dbMode = is_null($dbMode) ? SnapUtil::filterInputDefaultSanitizeString(INPUT_POST, '_package_dbmode') : $dbMode;
        $phpDumpMode = is_null($phpDumpMode) ? filter_input(
            INPUT_POST,
            '_phpdump_mode',
            FILTER_VALIDATE_INT,
            array('options' => array(
                        'default'   => 0,
                        'min_range' => 0,
                        'max_range' => 1
                    )
                )
        ) : $phpDumpMode;
        $dbMysqlDumpQueryLimit = is_null($dbMysqlDumpQueryLimit) ? filter_input(
            INPUT_POST,
            '_package_mysqldump_qrylimit',
            FILTER_VALIDATE_INT,
            array(
                    'options' => array(
                        'default'   => DUP_PRO_Constants::DEFAULT_MYSQL_DUMP_CHUNK_SIZE,
                        'min_range' => DUP_PRO_Constants::MYSQL_DUMP_CHUNK_SIZE_MIN_LIMIT,
                        'max_range' => DUP_PRO_Constants::MYSQL_DUMP_CHUNK_SIZE_MAX_LIMIT
                    )
                )
        ) : $dbMysqlDumpQueryLimit;

        $packageMysqldumpPath = is_null($packageMysqldumpPath) ?
            SnapUtil::filterInputDefaultSanitizeString(INPUT_POST, '_package_mysqldump_path') :
            $packageMysqldumpPath;
        $packageMysqldumpPath = SnapUtil::sanitizeNSCharsNewlineTrim($packageMysqldumpPath);
        $packageMysqldumpPath = preg_match('/^([A-Za-z]\:)?[\/\\\\]/', $packageMysqldumpPath) ? $packageMysqldumpPath : '';
        $packageMysqldumpPath = preg_replace('/[\'";]/m', '', $packageMysqldumpPath);
        $packageMysqldumpPath = SnapIO::safePathUntrailingslashit($packageMysqldumpPath);

        $mysqlDumpPath = empty($packageMysqldumpPath) ? DUP_PRO_DB::getMySqlDumpPath() : $packageMysqldumpPath;
        if ($dbMode == 'mysql' && empty($mysqlDumpPath)) {
            $dbMode = 'php';
        }

        $this->package_mysqldump          = $dbMode == 'mysql' ? 1 : 0;
        $this->package_phpdump_mode       = $phpDumpMode;
        $this->package_mysqldump_path     = $packageMysqldumpPath;
        $this->package_mysqldump_qrylimit = $dbMysqlDumpQueryLimit;
    }

    /**
     * Sets cleanup fields and configures WP Cron accordingly
     *
     * @param int    $cleanup_mode
     * @param string $cleanup_email
     * @param int    $auto_cleanup_hours
     *
     * @return void
     */
    public function setCleanupFields($cleanup_mode = null, $cleanup_email = null, $auto_cleanup_hours = null)
    {
        $this->cleanup_mode = is_null($cleanup_mode) ? filter_input(
            INPUT_POST,
            'cleanup_mode',
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'default'   => self::CLEANUP_MODE_OFF,
                    'min_range' => 0,
                    'max_range' => 2
                )
            )
        ) : $cleanup_mode;

        $this->cleanup_email = is_null($cleanup_email) ? $_REQUEST['cleanup_email'] : $cleanup_email;

        $this->auto_cleanup_hours = is_null($auto_cleanup_hours) ? filter_input(
            INPUT_POST,
            'auto_cleanup_hours',
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'default'   => 24,
                    'min_range' => 1
                )
            )
        ) : $auto_cleanup_hours;

        self::cleanupScheduleSetup();
    }

    /**
     * Schedules cron event for installer files cleanup purposes,
     * and unschedules it if it's not needed anymore.
     *
     * @return void
     */
    public static function cleanupScheduleSetup()
    {
        $global = self::get_instance();
        SnapWP::unscheduleEvent(self::CLEANUP_HOOK);
        if ($global->cleanup_mode == self::CLEANUP_MODE_MAIL) {
            $nextRunTime = time() + self::CLEANUP_EMAIL_NOTICE_INTERVAL * 3600;
            SnapWP::scheduleEvent($nextRunTime, self::CLEANUP_INTERVAL_NAME, self::CLEANUP_HOOK);
        } else if ($global->cleanup_mode == self::CLEANUP_MODE_AUTO) {
            $nextRunTime = time() + $global->auto_cleanup_hours * 3600;
            SnapWP::scheduleEvent($nextRunTime, self::CLEANUP_INTERVAL_NAME, self::CLEANUP_HOOK);
        }
    }

    /**
     * Customizes schedules according to current cleanup_mode. If necessary, it
     * adds a custom cron schedule that will run every N hours.
     *
     * @param array $schedules An array of non-default cron schedules.
     * 
     * @return array Filtered array of non-default cron schedules.
     */
    public static function customCleanupCronInterval($schedules)
    {
        $global = self::get_instance();

        switch ($global->cleanup_mode) {
            case self::CLEANUP_MODE_OFF:
                // No need to modify anything
                break;
            case self::CLEANUP_MODE_MAIL:
                $schedules[self::CLEANUP_INTERVAL_NAME] = array(
                    'interval' => self::CLEANUP_EMAIL_NOTICE_INTERVAL * 3600, // In seconds, every N hours
                    'display'  => sprintf(esc_html__('Every %1$d hours'), self::CLEANUP_EMAIL_NOTICE_INTERVAL)
                );
                break;
            case  self::CLEANUP_MODE_AUTO:
                $schedules[self::CLEANUP_INTERVAL_NAME] = array(
                    'interval' => $global->auto_cleanup_hours * 3600, // In seconds, every N hours
                    'display'  => sprintf(esc_html__('Every %1$d hours'), $global->auto_cleanup_hours)
                );
                break;
            default:
                throw new Exception('Invalid cleanup mode');
        }
        return $schedules;
    }

    /**
     * The function that gets executed by WP Cron for cleanup of installer files.
     * It does different tasks based on current cleanup_mode setting.
     *
     * @return void
     */
    public static function cleanupCronJob()
    {
        $global = self::get_instance();
        if ($global->cleanup_mode == self::CLEANUP_MODE_OFF) {
            return;
        }

        // At this point DUP_PRO_Log is not always initialized, so we have to do it
        \DUP_PRO_Log::init();
        $websiteUrl = \Duplicator\Libs\Snap\SnapURL::getCurrentUrl(false, false, 1);
        $to = $global->cleanup_email;
        if (empty($to)) {
            $to = get_option('admin_email');
        }

        if ($global->cleanup_mode == self::CLEANUP_MODE_MAIL) {
            // Email Notice cron job routine for cleanup of installer files

            $listOfInstallerFiles = \DUP_PRO_Migration::checkInstallerFilesList();
            $filesToRemove = array();

            foreach ($listOfInstallerFiles as $path) {
                if (self::CLEANUP_FILE_TIME_DELAY > 0) {
                    // We take into account only files older than CLEANUP_FILE_TIME_DELAY
                    if (time() - filectime($path) > self::CLEANUP_FILE_TIME_DELAY) {
                        $filesToRemove[] = $path;
                    }
                } else {
                    $filesToRemove[] = $path;
                }
            }

            if (count($filesToRemove) > 0 && !empty($to)) {
                // Send an Email Notice
                $subject  = __("Action required", 'duplicator-pro');
                $message = sprintf(__('This email is sent by your Wordpress plugin "Duplicator Pro" from website: %1$s. ', 'duplicator-pro'), $websiteUrl);
                $message .= __('You received this email because Cleanup mode is set to "Email Notice". ', 'duplicator-pro');
                $message .= __('Cleanup routine discovered that some installer files (leftovers from migration) were not removed. ', 'duplicator-pro');
                $message .= __('We strongly advise you to remove these files. ', 'duplicator-pro');
                $message .= __('Here is the list of files found on your website that you should remove:', 'duplicator-pro') . "<br/>";
                foreach ($filesToRemove as $path) {
                    $message .= "-> $path<br/>";
                }
                $message .= "<br/>";
                $message .= __('Note: You could enable "Auto Cleanup" mode if you go to:', 'duplicator-pro') . "<br/>";
                $message .= __('WordPress Admin > Duplicator Pro > Settings > Packages Tab > Cleanup.', 'duplicator-pro') . "<br/>";
                $message .= __('That mode will do cleanup of those files automatically for you.', 'duplicator-pro') . "<br/>";
                $message .= "<br/>";
                $message .= __('Best regards,', 'duplicator-pro') . "<br/>";
                $message .= __('Duplicator Pro', 'duplicator-pro');

                if (wp_mail($to, $subject, $message, array('Content-Type: text/html; charset=UTF-8'))) {
                    // OK
                    \DUP_PRO_Log::trace('wp_mail sent email notice regarding cleanup of installer files');
                } else {
                    \DUP_PRO_Log::trace("Problem sending email notice regarding cleanup of installer files to {$to}");
                }
            }
            return;
        } elseif ($global->cleanup_mode == self::CLEANUP_MODE_AUTO) {
            // Auto Cleanup cron job routine for cleanup of installer files

            $installerFiles = \DUP_PRO_Migration::cleanMigrationFiles(false, self::CLEANUP_FILE_TIME_DELAY);
            if (count($installerFiles) == 0) {
                // No installer files were found, so we do nothing else
                return;
            }

            $filesFailedRemoval = array();
            foreach ($installerFiles as $path => $success) {
                if (!$success) {
                    $filesFailedRemoval[] = $path;
                }
            }
            if (count($filesFailedRemoval) == 0) {
                // All found installer files were removed successfully,
                // or they did not even need to be removed yet because of CLEANUP_FILE_TIME_DELAY
                return;
            }

            // If this is executed that means that some of installer files
            // could not be removed for some reason (permission issues?)
            if (!empty($to)) {
                // Send an Email Notice about files that could not be removed during auto cleanup
                $subject  = __("Action required", 'duplicator-pro');
                $message = sprintf(__('This email is sent by your Wordpress plugin "Duplicator Pro" from website: %1$s. ', 'duplicator-pro'), $websiteUrl);
                $message .= __('"Auto Cleanup" mode is ON, ', 'duplicator-pro');
                $message .= __('however cleanup routine discovered that some installer files (leftovers from migration) could not be removed. ', 'duplicator-pro');
                $message .= __('We strongly advise you to remove those files manually. ', 'duplicator-pro');
                $message .= __('Here is the list of files found on your website that you should remove:', 'duplicator-pro') . "<br/>";
                foreach ($filesFailedRemoval as $path) {
                    $message .= "-> $path<br/>";
                }
                $message .= "<br/>";
                $message .= __('Those files probably could not be removed due to permission issues. ', 'duplicator-pro');
                $message .= sprintf(
                    __('You can find more info in FAQ %1$son this link%2$s.', 'duplicator-pro'),
                    "<a href='https://snapcreek.com/duplicator/docs/faqs-tech/#faq-trouble-perms-100-q' target='_blank'>",
                    "</a>"
                ) . "<br/>";
                $message .= "<br/>";
                $message .= __('Note: To edit "Cleanup" settings go to:', 'duplicator-pro') . "<br/>";
                $message .= __('WordPress Admin > Duplicator Pro > Settings > Packages Tab > Cleanup.', 'duplicator-pro') . "<br/>";
                $message .= "<br/>";
                $message .= __('Best regards,', 'duplicator-pro') . "<br/>";
                $message .= __('Duplicator Pro', 'duplicator-pro');

                if (wp_mail($to, $subject, $message, array('Content-Type: text/html; charset=UTF-8'))) {
                    // OK
                    \DUP_PRO_Log::trace('wp_mail sent email notice regarding failed auto cleanup of installer files');
                } else {
                    \DUP_PRO_Log::trace("Problem sending email notice regarding failed auto cleanup of installer files to {$to}");
                }
            }
            return;
        }
    }

    public function setArchiveMode($archiveBuildMode = null, $zipArchiveMode = null, $archiveCompression = null, $ziparchiveValidation = null, $ziparchiveChunkSizeInMb = null)
    {
        $isZipAvailable = (DUP_PRO_Zip_U::getShellExecZipPath() != null);

        $prelimBuildMode = is_null($archiveBuildMode) ? filter_input(
            INPUT_POST,
            'archive_build_mode',
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'min_range' => 1,
                    'max_range' => 3
                )
            )
        ) : $archiveBuildMode;

        // Something has changed which invalidates Shell exec so move it to ZA
        $this->archive_build_mode = (!$isZipAvailable && ($prelimBuildMode == DUP_PRO_Archive_Build_Mode::Shell_Exec)) ? DUP_PRO_Archive_Build_Mode::ZipArchive : $prelimBuildMode;
        $this->ziparchive_mode    = is_null($zipArchiveMode) ? filter_input(
            INPUT_POST,
            'ziparchive_mode',
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'default'   => 0,
                    'min_range' => 0,
                    'max_range' => 1
                )
            )
        ) : $zipArchiveMode;

        $this->archive_compression         = is_null($archiveCompression) ? filter_input(INPUT_POST, 'archive_compression', FILTER_VALIDATE_BOOLEAN) : $archiveCompression;
        $this->ziparchive_validation       = is_null($ziparchiveValidation) ? filter_input(INPUT_POST, 'ziparchive_validation', FILTER_VALIDATE_BOOLEAN) : $ziparchiveValidation;
        $this->ziparchive_chunk_size_in_mb = is_null($ziparchiveChunkSizeInMb) ? filter_input(
            INPUT_POST,
            'ziparchive_chunk_size_in_mb',
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'default'   => DUP_PRO_Constants::DEFAULT_ZIP_ARCHIVE_CHUNK,
                    'min_range' => 1
                )
            )
        ) : $ziparchiveChunkSizeInMb;
    }

    public function setClientsideKickoff($enable)
    {
        if ($this->clientside_kickoff != $enable) {
            $this->clientside_kickoff = $enable;

            if ($this->clientside_kickoff) {
                // Auto setting the max package runtime in case of client kickoff is turned on and
                // the max package runtime is less than 480 minutes - 8 hours
                $this->max_package_runtime_in_min = max(480, $this->max_package_runtime_in_min);
                $this->setDbMode('mysql');

                // RSR 4/29/19 not setting archive mode for now - too risky
                // $mode = (DUP_PRO_Zip_U::getShellExecZipPath() != null) ? DUP_PRO_Archive_Build_Mode::Shell_Exec : DUP_PRO_Archive_Build_Mode::DupArchive;
                // $this->setArchiveMode($mode);
            }
        }
    }

    // Important: Even though we are no longer using the encrypted lkp and basic_auth_user fields we still need them for upgrade purposes
    public function save()
    {
        $result = false;
        if ($this->crypt) {
            $this->encrypt();
        }
        $result = parent::save();
        if ($this->crypt) {
            $this->decrypt();   // Whenever its in memory its unencrypted
        }
        return $result;
    }

    // Change settings that may need to be changed because we have restored to a different system
    public function adjust_settings_for_system()
    {
        $save_required = false;
        if ($save_required) {
            $this->save();
        }
    }

    private function encrypt()
    {
        if (!empty($this->basic_auth_password)) {
            $this->basic_auth_password = CryptBlowfish::encrypt($this->basic_auth_password);
        }

        if (!empty($this->lkp)) {
            $this->lkp = CryptBlowfish::encrypt($this->lkp);
        }
    }

    private function decrypt()
    {
        if (!empty($this->basic_auth_password)) {
            $this->basic_auth_password = CryptBlowfish::decrypt($this->basic_auth_password);
        }

        if (!empty($this->lkp)) {
            $this->lkp = CryptBlowfish::decrypt($this->lkp);
        }
    }

    /**
     *
     * @return DUP_PRO_Global_Entity
     */
    public static function &get_instance()
    {
        if (!isset($GLOBALS[self::GLOBAL_NAME])) {
            $global  = null;
            $globals = DUP_PRO_JSON_Entity_Base::get_by_type(get_class());

            if (count($globals) === 0) {
                DUP_PRO_Log::trace("Global entity is null!");
                return $global;
            }

            $global = $globals[0];
            if ($global->crypt) {
                $global->decrypt();
            }

            if (!isset($global->onedrive_upload_chunksize_in_kb)) {
                DUP_PRO_Log::trace("Setting global var onedrive_upload_chunksize_in_kb to the " . DUPLICATOR_PRO_ONEDRIVE_UPLOAD_CHUNK_DEFAULT_SIZE_IN_KB . " manually.");
                $global->onedrive_upload_chunksize_in_kb = DUPLICATOR_PRO_ONEDRIVE_UPLOAD_CHUNK_DEFAULT_SIZE_IN_KB;
            }

            $GLOBALS[self::GLOBAL_NAME] = $global;
        }

        return $GLOBALS[self::GLOBAL_NAME];
    }

    public function configure_dropbox_transfer_mode()
    {
        if ($this->dropbox_transfer_mode == DUP_PRO_Dropbox_Transfer_Mode::Unconfigured) {
            $has_curl      = DUP_PRO_Server::isCurlEnabled();
            $has_fopen_url = DUP_PRO_Server::isURLFopenEnabled();

            if ($has_curl) {
                $this->dropbox_transfer_mode = DUP_PRO_Dropbox_Transfer_Mode::cURL;
            } else {
                if ($has_fopen_url) {
                    $this->dropbox_transfer_mode = DUP_PRO_Dropbox_Transfer_Mode::FOpen_URL;
                } else {
                    $this->dropbox_transfer_mode = DUP_PRO_Dropbox_Transfer_Mode::Disabled;
                }
            }

            $this->save();
        }
    }

    public function get_installer_backup_filename()
    {
        $installer_extension = $this->get_installer_extension();

        if (trim($installer_extension) == '') {
            return 'installer-backup';
        } else {
            return "installer-backup.$installer_extension";
        }
    }

    public function get_installer_extension()
    {
        return pathinfo($this->installer_base_name, PATHINFO_EXTENSION);
    }

    public function get_archive_engine()
    {
        $mode = '';
        switch ($this->archive_build_mode) {
            case DUP_PRO_Archive_Build_Mode::ZipArchive:
                $mode = ($this->ziparchive_mode == DUP_PRO_ZipArchive_Mode::Multithreaded) ? DUP_PRO_U::__("ZipArchive: multi-thread") : DUP_PRO_U::__("ZipArchive: single-thread");
                break;

            case DUP_PRO_Archive_Build_Mode::DupArchive:
                $mode = DUP_PRO_U::__('DupArchive');
                break;

            default:
                $mode = DUP_PRO_U::__("Shell Zip");
                break;
        }

        return $mode;
    }

    public function get_archive_extension_type()
    {
        $mode = 'zip';
        if ($this->archive_build_mode == DUP_PRO_Archive_Build_Mode::DupArchive) {
            $mode = 'daf';
        }
        return $mode;
    }
}
