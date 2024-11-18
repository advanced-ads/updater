# Framework

[![Framework](https://img.shields.io/badge/AdvancedAds-Updater-brightgreen)](https://wpadvancedads.com/)
[![Latest Stable Version](https://poser.pugx.org/advanced-ads/updater/v/stable)](https://packagist.org/packages/advanced-ads/updater)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/advanced-ads/updater.svg)](https://packagist.org/packages/advanced-ads/updater)
[![Total Downloads](https://poser.pugx.org/advanced-ads/updater/downloads)](https://packagist.org/packages/advanced-ads/updater)
[![License](https://poser.pugx.org/advanced-ads/updater/license)](https://packagist.org/packages/advanced-ads/updater)

<p align="center">
	<img src="https://img.icons8.com/nolan/256/minecraft-logo.png"/>
</p>

## 📃 About

This package allows plugins to use their own update API.

---

## 💾 Installation

``` bash
composer require advanced-ads/updater
```

## 🕹 Usage

```php
include('vendor/autoload.php');

// retrieve our license key from the DB
$license_key = trim( get_option( 'edd_sample_license_key' ) );
// setup the updater
$edd_updater = new AdvancedAds\Framework\EDD\Updater( 'STORE_URL', __FILE__, array(
    'version' => '1.0',		// current version number
    'license' => $license_key,	// license key (used get_option above to retrieve from DB)
    'item_id' => EDD_SAMPLE_ITEM_ID,	// id of this plugin
    'author'  => 'Author Name',	// author of this plugin
    'beta'    => false                // set to true if you wish customers to receive update notifications of beta releases
) );
```

## 📖 Changelog

[See the changelog file](./CHANGELOG.md)
