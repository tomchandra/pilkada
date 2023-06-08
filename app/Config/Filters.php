<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 */
	public array $aliases = [
		'csrf' => CSRF::class,
		'toolbar' => DebugToolbar::class,
		'honeypot' => Honeypot::class,
		'invalidchars' => InvalidChars::class,
		'secureheaders' => SecureHeaders::class,
		'session' => \CodeIgniter\Shield\Filters\SessionAuth::class,
		'tokens' => \CodeIgniter\Shield\Filters\TokenAuth::class,
		'chain' => \CodeIgniter\Shield\Filters\ChainAuth::class,
		'auth-rates' => \CodeIgniter\Shield\Filters\AuthRates::class,
		'group' => \CodeIgniter\Shield\Filters\GroupFilter::class,
		'permission' => \CodeIgniter\Shield\Filters\PermissionFilter::class,
		'force-reset' => \CodeIgniter\Shield\Filters\ForcePasswordResetFilter::class,
		'auth-access' => \App\Filters\AuthAccess::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 */
	public array $globals = [
		'before' => [
			'session' => ['except' => ['/', 'search*', 'login*', 'register*', 'auth*', 'oauth*']],
			'auth-access' => [
				'except' => [
					'login*',
					'logout*',
					'register*',
					'auth*',
					'pages/dashboard*',
					'pages/changepassword*',
					'pages/switchgroups*',
					'/'
				]
			],

			// 'honeypot',
			'csrf',
			'invalidchars',
		],
		'after' => [
			'toolbar',
			// 'honeypot',
			// 'secureheaders',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['foo', 'bar']
	 *
	 * If you use this, you should disable auto-routing because auto-routing
	 * permits any HTTP method to access a controller. Accessing the controller
	 * with a method you don’t expect could bypass the filter.
	 */
	public array $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 */
	public array $filters = [
		'auth-rates' => [
			'before' => [
				'login*',
				'register',
				'auth/*'
			]
		],
		// 'menu' => [
		// 	'before' => [
		// 		'systems/*',
		// 		'pages/*',
		// 	]
		// ]
	];
}
