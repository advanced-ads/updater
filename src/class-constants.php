<?php
/**
 * Constants.
 *
 * @package AdvancedAds\Framework
 * @author Easy Digital Downloads
 * @version 1.9.4
 */

namespace AdvancedAds\Framework\EDD;

defined( 'ABSPATH' ) || exit;

/**
 * Constants.
 */
class Constants {
	/**
	 * License API endpoint URL
	 *
	 * @const string
	 */
	const API_ENDPOINT = 'https://wpadvancedads.com/license-api/';

	/**
	 * Add-on slugs and their EDD ID
	 *
	 * @const array
	 */
	const ADDON_SLUGS_ID = [
		'advanced-ads-gam'        => 215545,
		'advanced-ads-layer'      => 686,
		'advanced-ads-pro'        => 1742,
		'advanced-ads-responsive' => 678,
		'advanced-ads-selling'    => 35300,
		'advanced-ads-sticky'     => 683,
		'advanced-ads-tracking'   => 638,
	];
}
