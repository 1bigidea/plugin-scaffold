<?php

/**
 * Adds CLI package comand for custom plugin.
 *
 * @package WP_CLI
 */

namespace WP_CLI;

use WP_CLI;
use WP_CLI\Process;
use WP_CLI\Utils;

/**
 * Class ScaffoldCustomPluginCommand
 *
 * @package WP_CLI
 */
class Scaffold1BigIdeaPluginCommand
{

	/**
	 * Generates starter code for a plugin.
	 *
	 * The following files are always generated:
	 *
	 * * `plugin-slug.php` is the main PHP plugin file.
	 * * `readme.txt` is the readme file for the plugin.
	 * * `package.json` needed by NPM holds various metadata relevant to the project. Packages: `grunt`, `grunt-wp-i18n` and `grunt-wp-readme-to-markdown`.
	 * * `.editorconfig` is the configuration file for Editor.
	 * * `.gitignore` tells which files (or patterns) git should ignore.
	 * * `.distignore` tells which files and folders should be ignored in distribution.
	 *
	 * The following folders are always created:
	 *
	 * * `assets/js`
	 * * `assets/css`
	 * * `assets/images`
	 * * `src/scss`
	 * * `src/js`
	 *
	 * The following files are also included unless the `--skip-tests` is used:
	 *
	 * * `phpunit.xml.dist` is the configuration file for PHPUnit.
	 * * `.travis.yml` is the configuration file for Travis CI. Use `--ci=<provider>` to select a different service.
	 * * `bin/install-wp-tests.sh` configures the WordPress test suite and a test database.
	 * * `tests/bootstrap.php` is the file that makes the current plugin active when running the test suite.
	 * * `tests/test-sample.php` is a sample file containing test cases.
	 * * `phpcs.xml.dist` is a collection of PHP_CodeSniffer rules.
	 *
	 * ## OPTIONS
	 *
	 * <slug>
	 * : The internal name of the plugin.
	 *
	 * [--dir=<dirname>]
	 * : Put the new plugin in some arbitrary directory path. Plugin directory will be path plus supplied slug.
	 *
	 * [--plugin_name=<title>]
	 * : What to put in the 'Plugin Name:' header.
	 *
	 * [--plugin_description=<description>]
	 * : What to put in the 'Description:' header.
	 *
	 * [--plugin_author=<author>]
	 * : What to put in the 'Author:' header.
	 *
	 * [--plugin_author_uri=<url>]
	 * : What to put in the 'Author URI:' header.
	 *
	 * [--plugin_uri=<url>]
	 * : What to put in the 'Plugin URI:' header.
	 *
	 * [--skip-tests]
	 * : Don't generate files for unit testing.
	 *
	 * [--ci=<provider>]
	 * : Choose a configuration file for a continuous integration provider.
	 * ---
	 * default: travis
	 * options:
	 *   - travis
	 *   - circle
	 *   - gitlab
	 * ---
	 *
	 * [--activate]
	 * : Activate the newly generated plugin.
	 *
	 * [--activate-network]
	 * : Network activate the newly generated plugin.
	 *
	 * [--force]
	 * : Overwrite files that already exist.
	 *
	 * ## EXAMPLES
	 *
	 *     $ wp scaffold bespoke_plugin sample-plugin
	 *     Success: Created plugin files.
	 *     Success: Created test files.
	 *
	 * @param array $args       The CLI arguments.
	 * @param array $assoc_args The CLI associative args array.
	 */
	//https://docs.wpvip.com/how-tos/write-custom-wp-cli-commands/
	public function __invoke($args, $assoc_args)
	{

		WP_CLI::run_command(array('scaffold', 'plugin', $args[0]), $assoc_args);

		$plugin_slug = $args[0];

		if (!empty($assoc_args['dir'])) {
			if (!is_dir($assoc_args['dir'])) {
				WP_CLI::error("Cannot create plugin in directory that doesn't exist.");
			}
			$plugin_dir = $assoc_args['dir'] . "/$plugin_slug";
		} else {
			$plugin_dir = WP_PLUGIN_DIR . "/$plugin_slug";
		}

		$this->create_directories(array(
			"{$plugin_dir}/assets",
			"{$plugin_dir}/assets/js",
			"{$plugin_dir}/assets/css",
			"{$plugin_dir}/assets/images",
			"{$plugin_dir}/src/",
			"{$plugin_dir}/src/scss",
			"{$plugin_dir}/src/js",
		));
		/*
			$files_to_create = [
			$plugin_path                  => self::mustache_render( 'plugin.mustache', $data ),
			$plugin_readme_path           => self::mustache_render( 'plugin-readme.mustache', $data ),
			"{$plugin_dir}/package.json"  => self::mustache_render( 'plugin-packages.mustache', $data ),
			"{$plugin_dir}/Gruntfile.js"  => self::mustache_render( 'plugin-gruntfile.mustache', $data ),
			"{$plugin_dir}/.gitignore"    => self::mustache_render( 'plugin-gitignore.mustache', $data ),
			"{$plugin_dir}/.distignore"   => self::mustache_render( 'plugin-distignore.mustache', $data ),
			"{$plugin_dir}/.editorconfig" => file_get_contents( self::get_template_path( '.editorconfig' ) ),
		];
		*/
	}

	/**
	 * Creates directories.
	 *
	 * @param array $directories Array of directories to create.
	 */
	private function create_directories($directories)
	{
		foreach ($directories as $directory) {
			if (!is_dir($directory)) {
				Process::create(Utils\esc_cmd('mkdir -p %s', $directory))->run();
			}
		}
	}
}

WP_CLI::add_command('scaffold bespoke_plugin', 'Scaffold1BigIdeaPluginCommand');
