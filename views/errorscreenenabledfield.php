<?php
/**
 * editor screen enable field.
 * 
 * HTML for the editor screen enable field.
 * 
 * @package Microbe
 * @since 1.0.0
 * 
 * @uses get_option https://developer.wordpress.org/reference/functions/get_option/
 * @uses get_option https://developer.wordpress.org/reference/functions/selected/
 */
?>

<?php
$current_value = \get_option('_microbe_error_screen_enabled'); 
?>

<select name="_microbe_error_screen_enabled">
    
    <option value="yes" <?php \selected( $current_value , 'yes' ); ?>>Yes</option>
    <option value="no" <?php \selected( $current_value , 'no' ); ?>>No</option>
</select>