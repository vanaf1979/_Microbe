<?php
/**
 * Microbe
 *
 * @package           Microbe
 * @author            Stephan Nijman <vanaf1979@gmail.com>
 * @copyright         2019 Stephan Nijman
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       _Microbe
 * Plugin URI:        https://vanaf1979.nl
 * Description:       A beter debugging experience for WordPress.
 * Version:           1.0.0
 * Requires at least: 5.1
 * Requires PHP:      7.0
 * Author:            Stephan Nijman
 * Author URI:        https://vanaf1979.nl
 * Text Domain:       _microbe
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


 /**
 * Set namespace.
 */
namespace Microbe;


/**
 * Load the composer autoload file.
 */
require_once __DIR__ . '/vendor/autoload.php';


/**
 * Use dependencies
 */
use \Whoops\Handler\PrettyPageHandler;
use \Whoops\Run;


/**
 * Check WordPress context.
 */
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Microbe
 * 
 * Main Microbe plugin class
 * 
 * @author Stephan Nijman <vanaf1979@gmail.com>
 *
 * @package Microbe
 */
final class Microbe {


    /**
     * instance.
     * 
     * @var Microbe $instance instance instance.
     *
     * @access private
     * @since 1.0.0
     */
    private static $instance;


    /**
     * editor
     * 
     * @var string $editor Default editor setting.
     * 
     * @access private
     * @since 1.0.0
     */
    private $editor;


    /**
     * __construct.
     *
     * Initialize properties.
     *
     * @since 1.0.0
     */
    public function __construct() {

        $this->editor = 'vscode';

    }


    /**
     * instance.
     *
     * Return a instance of this class.
     *
     * @access public
     * @since 1.0.0
     */
    public static function instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof \Microbe\Microbe ) ) {

            self::$instance = new Self();

        }

        return self::$instance;

    }


    /**
     * init
     *
     * initialize the plugin.
     *
     * @access public
     * @return void
     */
    public function init() : void {

        if( WP_DEBUG ) {

            $this->init_whoops();

        }
        
    }


    /**
     * init_whoops.
     * 
     * Initialize the Whoops package.
     * 
     * @uses Whoops https://github.com/filp/whoops
     * 
     * @access private
     * @return void
     */
    private function init_whoops() : void {

        $handler = new PrettyPageHandler;
        $handler->setEditor('vscode');
        $whoops = new Run;
        $whoops->prependHandler($handler);
        $whoops->register();

        // echo $i_don_exist;

    }

}


/**
 * runMicrobe.
 * 
 * Initialize the Microbe plugin.
 * 
 * @uses Microbe
 * 
 * @return void
 */
function runMicrobe() : void {

    \Microbe\Microbe::instance()->init();

}

runMicrobe();
?>