<?php
/**
 * Addon updater.
 *
 * @package AdvancedAds\Framework
 * @author Easy Digital Downloads
 * @version 1.9.4
 */

namespace AdvancedAds\Framework\EDD;

use AdvancedAds\Framework\Interfaces\Integration_Interface;

defined( 'ABSPATH' ) || exit;

/**
 * Class addon updater
 */
abstract class Addon_Updater implements Integration_Interface {
	/**
	 * Hook into WordPress.
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_action( 'admin_init', [ $this, 'add_on_updater' ], 1 );
		add_filter( 'advanced-ads-add-ons', [ $this, 'register_auto_updater' ] );
	}

	/**
	 * Get the data for the plugin.
	 *
	 * @return array
	 */
	abstract public function get_data(): array;

	/**
	 * Get plugin unique id.
	 *
	 * @return string
	 */
	abstract public function get_id(): string;

	/**
	 * Register plugin for the auto updater in the base plugin
	 *
	 * @param array $plugins plugin that are already registered for auto updates.
	 *
	 * @return array
	 */
	public function register_auto_updater( array $plugins = [] ) {
		$plugins[ $this->get_id() ] = $this->get_data();

		return $plugins;
	}

	/**
	 * Register the Updater class for every add-on, which includes getting version information
	 */
	public function add_on_updater() {
		// Ignore, if not main blog or if updater was disabled.
		if ( ( is_multisite() && ! is_main_site() ) || ! apply_filters( 'advanced-ads-add-ons-updater', true ) ) {
			return;
		}

		$_add_on_key  = $this->get_id();
		$_add_on      = $this->get_data();
		$options_slug = $_add_on['options_slug'];

		// Check if a license expired over time.
		$expiry_date = $this->get_license_expires( $options_slug );
		$now         = time();
		if ( $expiry_date && 'lifetime' !== $expiry_date && strtotime( $expiry_date ) < $now ) {
			// Remove license status.
			delete_option( $options_slug . '-license-status' );
		}

		// Retrieve our license key.
		$licenses    = get_option( ADVADS_SLUG . '-licenses', [] );
		$license_key = $licenses[ $_add_on_key ] ?? '';

		// By default, EDD looks every 3 hours for updates. The following code block changes that to 24 hours. set_expiration_of_update_option delivers that value.
		$option_key = 'pre_update_option_edd_sl_' . md5( serialize( basename( $_add_on['path'], '.php' ) . $license_key ) );
		add_filter( $option_key, [ $this, 'set_expiration_of_update_option' ] );

		( new EDD_Updater(
			Constants::API_ENDPOINT,
			$_add_on['path'],
			[
				'version'   => $_add_on['version'],
				'license'   => $license_key,
				'item_id'   => Constants::ADDON_SLUGS_ID[ $options_slug ] ?? false,
				'item_name' => $_add_on['name'],
				'author'    => 'Advanced Ads',
			]
		) );
	}

	/**
	 * Get license expired value of an add-on
	 *
	 * @param string $slug slug of the add-on.
	 *
	 * @return string $date expiry date of an add-on, empty string if no option exists
	 */
	public function get_license_expires( $slug = '' ) {
		return get_option( $slug . '-license-expires', '' );
	}
}
