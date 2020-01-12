<?php

namespace techPump\Config;

final class Config {

	private function __construct() {}

	public const SITES_DIRECTORY = '/var/www/html/public/sites';

	public const ADMIN_USER = 'admin';
	public const ADMIN_PASSWD = 'techpump';

	/** @var int how many photos between two big photos( included last ) */
	public const OUTSTANDING_CHICAS_INTERVAL = 12;
	public const WEBCAMS_LINK = 'http://webcams.cumlouder.com/joinmb/cumlouder/%s';
	public const IMAGES_URL = 'https://w0.imgcm.com/modelos/%s';

	public const CDN_URL = 'http://cdn.techpump.local:8080/%s';

	public const CACHE_EXPIRATION_TIME = 15 * 60; //15 minutes
}