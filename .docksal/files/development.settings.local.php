<?php

// phpcs:ignoreFile

/**
 * @file
 * Local development override configuration feature.
 */

/**
 * Assertions.
 */
assert_options(ASSERT_ACTIVE, TRUE);
assert_options(ASSERT_EXCEPTION, TRUE);

/**
 * Enable local development services.
 */
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';

/**
 * Show all error messages, with backtrace information.
 */
$config['system.logging']['error_level'] = 'verbose';

/**
 * Skip file system permissions hardening.
 */
$settings['skip_permissions_hardening'] = TRUE;

/**
 * Trusted host configuration.
 */
$settings['trusted_host_patterns'] = [
  '^.+\.docksal.site$',
  '^.+\.docksal$',
  '^(.*?).fivejars\.com$',
  '^(.*?).fivejars\.net$',
];

/**
 * Configuration overrides for Config split.
 */
$config["config_split.config_split.dev"]["status"] = TRUE;

/**
 * Configuration overrides for OpenAI integration.
 */
if (getenv('OPENAI_API_KEY')) {
  $config["openai.settings"]["api_key"] = getenv('OPENAI_API_KEY');
  $config["metatag_ai.settings"]["metatag_ai"]["metatagai_token"] = getenv('OPENAI_API_KEY');
}
