<?php
/**
 * editor field.
 * 
 * HTML for the editor  field.
 * 
 * @package Microbe
 * @since 1.0.0
 * 
 * @uses get_option https://developer.wordpress.org/reference/functions/get_option/
 * @uses get_option https://developer.wordpress.org/reference/functions/selected/
 */
?>

<?php
$current_value = \get_option('_microbe_editor'); 
?>

<select name="_microbe_editor">
    <option value="">Select your editor</option>
    <option value="sublime" <?php \selected( $current_value, 'sublime' ); ?>>sublime</option>
    <option value="textmate" <?php \selected( $current_value, 'textmate' ); ?>>textmate</option>
    <option value="emacs" <?php \selected( $current_value, 'emacs' ); ?>>emacs</option>
    <option value="macvim" <?php \selected( $current_value, 'macvim' ); ?>>macvim</option>
    <option value="phpstorm" <?php \selected( $current_value, 'phpstorm' ); ?>>phpstorm</option>
    <option value="idea" <?php \selected( $current_value, 'idea' ); ?>>idea</option>
    <option value="vscode" <?php \selected( $current_value, 'vscode' ); ?>>vscode</option>
    <option value="atom" <?php \selected( $current_value, 'atom' ); ?>>atom</option>
    <option value="espresso" <?php \selected( $current_value, 'espresso' ); ?>>espresso</option>
    <option value="xdebug" <?php \selected( $current_value, 'xdebug' ); ?>>xdebug</option>
</select>