<?php
/**
 * Microbe
 *
 * @package             Microbe
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @copyright           2019 Stephan Nijman
 * @license             GPL-2.0-or-later
 * @version             1.0.0
 * 
 * @uses Whoops https://github.com/filp/whoops
 * @uses Var-dumper https://github.com/symfony/var-dumper
 *
 * @wordpress-plugin
 * Plugin Name:         _Microbe
 * Plugin URI:          https://vanaf1979.nl
 * Description:         A beter debugging experience for WordPress.
 * Version:             1.0.0
 * Requires at least:   5.1
 * Requires PHP:        7.0
 * Author:              Stephan Nijman
 * Author URI:          https://vanaf1979.nl
 * Text Domain:         _microbe
 * License:             GPL v2 or later
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
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
 * Use dependencies.
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
 * Main Microbe plugin class.
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
    private static $instance = null;


    /**
     * editor
     * 
     * @var string $editor Default editor setting.
     * 
     * @access private
     * @since 1.0.0
     */
    private $editor = null;


    /**
     * whoops_enabled
     * 
     * @var string $whoops_enabled Is the error screen enabled.
     * 
     * @access private
     * @since 1.0.0
     */
    private $whoops_enabled = null;


    /**
     * instance.
     *
     * Return a instance of this class.
     *
     * @since 1.0.0
     * 
     * @access public
     * @return Microbe
     */
    public static function instance() : Microbe {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof \Microbe\Microbe ) ) {

            self::$instance = new Self();

        }

        return self::$instance;

    }


    /**
     * __clone
     * 
     * Throw error on object clone.
     * 
     * @uses _doing_it_wrong https://developer.wordpress.org/reference/functions/_doing_it_wrong/
     * @uses esc_html__ https://developer.wordpress.org/reference/functions/esc_html__/
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function __clone() {

        \_doing_it_wrong( __FUNCTION__ , \esc_html__( 'Cheating huh?', '_micobe' ), '1.0' );

    }

    
    /**
     * __wakeup
     * 
     * Disable unserializing of the class.
     * 
     * @uses _doing_it_wrong https://developer.wordpress.org/reference/functions/_doing_it_wrong/
     * @uses esc_html__ https://developer.wordpress.org/reference/functions/esc_html__/
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function __wakeup() {

        \_doing_it_wrong( __FUNCTION__ , \esc_html__( 'Cheating huh?' , '_micobe' ) , '1.0' );

    }


    /**
     * init
     *
     * initialize the plugin.
     * 
     * @uses get_option https://developer.wordpress.org/reference/functions/get_option/
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function init() : void {

        $this->whoops_enabled = \get_option('_microbe_error_screen_enabled'); 

        $this->editor = \get_option('_microbe_editor');

        if( WP_DEBUG ) {

            $this->init_whoops();

        }

        $this->register_wp_hooks();
        
    }


    /**
     * init_whoops.
     * 
     * Initialize the Whoops package.
     * 
     * @uses Whoops https://github.com/filp/whoops
     * @uses get_option https://developer.wordpress.org/reference/functions/get_option/
     *
     * @since 1.0.0
     *  
     * @access private
     * @return void
     */
    private function init_whoops() : void {

        if( $this->whoops_enabled == 'yes' || $this->whoops_enabled == '' ) {

            $handler = new PrettyPageHandler;

            if( $this->editor ) {
                
                $handler->setEditor( $this->editor );

            }
            
            $whoops = new Run;
            $whoops->prependHandler( $handler );
            $whoops->register();

        }
        
    }


    /**
     * register_wp_hooks.
     *
     * Register hooks with WordPress.
     * 
     * @uses add_action https://developer.wordpress.org/reference/functions/add_action/
     *
     * @since 1.0.0
     * 
     * @access private
     * @return void
     */
    private function register_wp_hooks() : void {
        
        \add_action( 'admin_init', array( $this , 'settings_api_init' ) );
        \add_action( 'init', array( $this , 'register_settings' ) );

    }


    /**
     * settings_api_init.
     *
     * Add settings section and fields.
     * 
     * @uses add_settings_section https://developer.wordpress.org/reference/functions/add_settings_section/
     * @uses add_settings_field https://developer.wordpress.org/reference/functions/add_settings_field/
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function settings_api_init() : void {
        
        \add_settings_section(
            'microbe',
            'Microbe',
            array( $this , 'microbe_callback_function' ),
            'general'
        );

        \add_settings_field(
            'errorscreen-enabled',
            'Error screen enabled',
            array( $this , 'error_screen_enabled_callback_function' ),
            'general',
            'microbe',
            array(
                'name'  => 'editor',
                'label' => 'Editor',
            )
        );
    
        \add_settings_field(
            'editor',
            'Editor',
            array( $this , 'edotor_callback_function' ),
            'general',
            'microbe',
            array(
                'name'  => 'editor',
                'label' => 'Editor',
            )
        );
    }


    /**
     * microbe_callback_function.
     *
     * Adds settings section html.
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function microbe_callback_function() : void {

        echo '<p>Please select you editor.</p>';

    }


    /**
     * error_screen_enabled_callback_function.
     *
     * Adds html for the error screen enabled option.
     * 
     * @uses require_once https://www.php.net/manual/en/function.require-once.php
     * @uses plugin_dir_path https://developer.wordpress.org/reference/functions/plugin_dir_path/
     * @uses dirname https://www.php.net/manual/en/function.dirname.php
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function error_screen_enabled_callback_function( $args ) : void {

        require_once( \plugin_dir_path( \dirname( __FILE__ ) ) . '_microbe/views/errorscreenenabledfield.php' );

    }
    

    /**
     * edotor_callback_function.
     *
     * Adds html for the editor option.
     * 
     * @uses require_once https://www.php.net/manual/en/function.require-once.php
     * @uses plugin_dir_path https://developer.wordpress.org/reference/functions/plugin_dir_path/
     * @uses dirname https://www.php.net/manual/en/function.dirname.php
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function edotor_callback_function( $args ) : void {

        require_once( \plugin_dir_path( \dirname( __FILE__ ) ) . '_microbe/views/editorfield.php' );

    }
    
    
    /**
     * register_settings.
     *
     * Register options with WordPRess.
     * 
     * @uses register_setting https://developer.wordpress.org/reference/functions/register_setting/
     *
     * @since 1.0.0
     * 
     * @access public
     * @return void
     */
    public function register_settings() : void  {

        $args = array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => 'yes',
        );

        \register_setting( 'general' , '_microbe_error_screen_enabled' , $args );


        $args = array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => null,
        );

        \register_setting( 'general' , '_microbe_editor' , $args );

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