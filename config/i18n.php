<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * I18n library configuration file
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Lawrence Cheung
 * @version     1.0
 * @link        https://github.com/lawrence0819
 */

//Add file in this array, if you want I18n library auto load them
$config['language']['files'] = array('common', 'admin', 'user', 'message', 'form_validation', 'db');

//If user locale not found, set this valus as a defaul user locale
$config['language']['default_locale'] = 'zh-TW';

//zh-TW locale mapped to tchinese folder
$config['language']['locale'] = [
	'zh-TW' => '繁體中文 (TW)',
	'zh-HK' => '繁體中文 (HK)',
	'zh-CN' => '简体中文 (CN)',
	'ja-JP' => '日本語',
	'ko-KR' => '한국어',
	'en-US' => 'English (US)',
];

/* End of file i18n.php */
/* Location: ./application/config/i18n.php */