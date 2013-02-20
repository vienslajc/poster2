<?php

/**
 * The Independt plugin for Q&A
 *
 * indqa is forum software with a twist from the creators of WordPress.
 *
 * $Id: indqa.php 4711 2013-01-24 16:57:02Z johnjamesjacoby $
 *
 * @package independt
 * @subpackage Main
 */

/**
 * Plugin Name: Independt - Questions & réponses
 * Plugin URI:  http://www.independt.com
 * Description: Plugin permettant d'ajouter la fonctionnalité d'ajout de question
 * Author:      The indqa Community
 * Author URI:  http://www.independt.com
 * Version:     0.1
 * Text Domain: independt
 * Domain Path: /languages/
 */
?><?php

// some definition we will use
define( 'INDQA_PUGIN_NAME', 'Independt QA');
define( 'INDQA_PLUGIN_DIRECTORY', 'independt-qa');
define( 'INDQA_CURRENT_VERSION', '0.1' );
define( 'INDQA_CURRENT_BUILD', '1' );
define( 'INDQA_LOGPATH', str_replace('\\', '/', WP_CONTENT_DIR).'/contest-logs/');
define( 'INDQA_DEBUG', true);		# never use debug mode on productive systems
// i18n plugin domain for language files
define( 'EMU2_I18N_DOMAIN', 'independt' );

// how to handle log files, don't load them if you don't log
require_once('indqa_logfilehandling.php');

require_once('indqa_functions.php');

indqa_set_lang_file();

// create custom plugin settings menu
add_action( 'admin_menu', 'indqa_create_menu' );

//call register settings function
add_action( 'admin_init', 'indqa_register_settings' );

add_action('generate_rewrite_rules', 'indqa_create_rewrite_rules');

add_action('template_redirect', 'indqa_template');


register_activation_hook(__FILE__, 'indqa_activate');
register_deactivation_hook(__FILE__, 'indqa_deactivate');
register_uninstall_hook(__FILE__, 'indqa_uninstall');

add_filter('query_vars', 'indqa_query_vars');

add_action( 'init', 'indqa_init' );

/* -----------------------------------------------------------------------
 *
 *
 *                          INITIALISATION
 *
 *
 * ----------------------------------------------------------------------- */

function indqa_init() {

    require('includes/admin/custom_config.php');

    indqa_register_post_types();
    indqa_register_post_statuses();
    indqa_register_taxonomies();

//    indqa_add_vote(761,'indqa_replies',1);
}

function indqa_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    indqa_init();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );

// activating the default values
function indqa_activate() {

    $roles = array('administrator', 'editor', 'author', 'contributor', 'subscriber');

    foreach($roles as $role_name) {
        $role = get_role($role_name);

        $role->add_cap( 'edit_indqa_topics' );
        $role->add_cap( 'edit_indqa_others_topics' );
        $role->add_cap( 'publish_indqa_topics' );
        $role->add_cap( 'read_indqa_private_topics' );
        $role->add_cap( 'read_indqa_hidden_topics' );
        $role->add_cap( 'delete_indqa_topics' );
        $role->add_cap( 'delete_indqa_others_topics' );
        $role->add_cap( 'edit_indqa_post' );
        $role->add_cap( 'delete_indqa_post' );
        $role->add_cap( 'read_indqa_post' );

    }
}

// deactivating
function indqa_deactivate() {
}

// uninstalling
function indqa_uninstall() {
	// delete log files and folder only if needed
	if (function_exists('indqa_deleteLogFolder')) indqa_deleteLogFolder();
}

function indqa_create_menu() {
    $hooks = array();

    // These are later removed in admin_head
    if ( is_admin() ) {

        // Forums Tools Root
        add_options_page(
            __( 'Independt Q&A', 'independt' ),
            __( 'Independt Q&A', 'independt' ),
            'manage_options',
            'indqa-settings',
            'indqa_admin_settings'
        );
    }

}

function indqa_register_settings() {

}

/* -----------------------------------------------------------------------
 *
 *
 *                          STYLES / CSS
 *
 *
 * ----------------------------------------------------------------------- */

function indqa_add_script ()
{
    //wp_enqueue_script ('pmpt_main_js', plugins_url ('js/script.js', __FILE__), array (), false, true);
}
add_action( 'admin_footer', 'indqa_add_script');

/*
 * vla_spt_add_script
 * Ajout des styles
 */

function indqa_add_styles ()
{
    wp_register_style('indqa-styles',plugins_url ('includes/elements/css/styles.css', __FILE__),array(),false,'all');
    wp_enqueue_style( 'indqa-styles');
}
add_action( 'admin_head', 'indqa_add_styles');


/* -----------------------------------------------------------------------
 *
 *
 *                          PAGES
 *
 *
 * ----------------------------------------------------------------------- */

function indqa_admin_settings() {
    require('includes/admin/settings.php');
}

/* -----------------------------------------------------------------------
 *
 *
 *                          POST / SAVE_POST
 *
 *
 * ----------------------------------------------------------------------- */

function process_post(){
    require_once('includes/vars/post.php');
}

add_action('init', 'process_post');

function indqa_save_postdata($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $termid = get_post_meta($post_id, '_termid', true);

    if ($termid != '') {

        $current_user = wp_get_current_user();

        if('indqa_topics' == $_POST['post_type']) {
            $topics_count = get_user_meta($current_user->ID,'_indqa_topics_count',true);
            if(!$topics_count) $topics_count = 0;
            update_user_meta( $current_user->ID, '_indqa_topics_count', $topics_count++ );

        } else if('indqa_queries' == $_POST['post_type']) {
            $queries_count = get_user_meta($current_user->ID,'_indqa_queries_count',true);
            if(!$queries_count) $queries_count = 0;
            update_user_meta( $current_user->ID, '_indqa_queries_count', $queries_count++ );
        }

        $termid = 'update';
    } else {
        // it's an existing record
    }
    update_post_meta($post_id, '_termid', $termid);
}
add_action('save_post', 'indqa_save_postdata');


/* -----------------------------------------------------------------------
 *
 *
 *                          ADMIN META BOX
 *
 *
 * ----------------------------------------------------------------------- */

function indqa_add_meta_boxes() {

    require_once('includes/admin/vote_boxes.php');

    // Ajoute une box permettant de lier une réponse à un topic
    require_once('includes/admin/topic_boxes.php');
    indqa_add_replie_boxes();

    // Ajoute une box permettant de lister l'ensemble des réponses à un topic
    require_once('includes/admin/replie_boxes.php');
    indqa_add_topic_boxes();

}

add_action("admin_init", "indqa_add_meta_boxes");



/* -----------------------------------------------------------------------
 *
 *
 *                          REWRITE URL
 *
 *
 * ----------------------------------------------------------------------- */




function indqa_create_rewrite_rules() {
    global $wp_rewrite;

    /*

    // add rewrite tokens
    $ubid = '%contestid%';
    $wp_rewrite->add_rewrite_tag($ubid, '(.+?)', 'contestid=');

    $url_structure = $wp_rewrite->root . "gotcha/$ubid";
    $url_rewrite = $wp_rewrite->generate_rewrite_rules($url_structure);

    $wp_rewrite->rules = $url_rewrite + $wp_rewrite->rules;

    */

    return $wp_rewrite->rules;
}

function indqa_query_vars($public_query_vars) {

    //$public_query_vars[] = "contestid";

    /*	Note: you do not want to add a variable multiple times.  As in
         the example above, multiple rules can use the same variables
     */

    return $public_query_vars;
}

function indqa_template() {
    //if(get_query_var('contestid')) route_gotcha(array('id'=>get_query_var('contestid')));
}

/* -----------------------------------------------------------------------
 *
 *
 *                          DEBUG
 *
 *
 * ----------------------------------------------------------------------- */

// check if debug is activated
function indqa_debug() {
	# only run debug on localhost
	if ($_SERVER["HTTP_HOST"]=="localhost" && defined('EPS_DEBUG') && EPS_DEBUG==true) return true;
}

?>
