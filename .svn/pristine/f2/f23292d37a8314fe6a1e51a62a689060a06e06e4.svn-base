<?php

function indqa_register_post_types() {

    // Define local variable(s)
    $post_type = array();

    /** Topics ************************************************************/

    // Topic labels
    $post_type['labels'] = array(
        'name'               => __( 'Topics',                   'independt' ),
        'menu_name'          => __( 'Topics',                   'independt' ),
        'singular_name'      => __( 'Topic',                    'independt' ),
        'all_items'          => __( 'All Topics',               'independt' ),
        'add_new'            => __( 'New Topic',                'independt' ),
        'add_new_item'       => __( 'Create New Topic',         'independt' ),
        'edit'               => __( 'Edit',                     'independt' ),
        'edit_item'          => __( 'Edit Topic',               'independt' ),
        'new_item'           => __( 'New Topic',                'independt' ),
        'view'               => __( 'View Topic',               'independt' ),
        'view_item'          => __( 'View Topic',               'independt' ),
        'search_items'       => __( 'Search Topics',            'independt' ),
        'not_found'          => __( 'No topics found',          'independt' ),
        'not_found_in_trash' => __( 'No topics found in Trash', 'independt' )
    );

    // Topic rewrite
    $post_type['rewrite'] = array(
        'slug'       => 'topics',
        'with_front' => false
    );

    // Topic supports
    $post_type['supports'] = array(
        'title',
        'editor',
        'revisions'
    );

    // Register Topic content type
    register_post_type(
        'indqa_topics',
        array(
            'labels'              => $post_type['labels'],
            'rewrite'             => $post_type['rewrite'],
            'supports'            => $post_type['supports'],
            'description'         => __( 'Independt Q&A Topics', 'independt' ),
            'capabilities'        => indqa_get_topics_caps(),
            'capability_type'     => array( 'topic', 'topics' ),
            'menu_position'       => 555555,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'show_in_nav_menus'   => true,
            'public'              => true,
            'show_ui'             => true,
            'can_export'          => true,
            'hierarchical'        => false,
            'query_var'           => true,
            'menu_icon'           => ''
        ) );

    /** Replies ***********************************************************/

    // Reply labels
    $post_type['labels'] = array(
        'name'               => __( 'Replies',                   'independt' ),
        'menu_name'          => __( 'Replies',                   'independt' ),
        'singular_name'      => __( 'Reply',                     'independt' ),
        'all_items'          => __( 'All Replies',               'independt' ),
        'add_new'            => __( 'New Reply',                 'independt' ),
        'add_new_item'       => __( 'Create New Reply',          'independt' ),
        'edit'               => __( 'Edit',                      'independt' ),
        'edit_item'          => __( 'Edit Reply',                'independt' ),
        'new_item'           => __( 'New Reply',                 'independt' ),
        'view'               => __( 'View Reply',                'independt' ),
        'view_item'          => __( 'View Reply',                'independt' ),
        'search_items'       => __( 'Search Replies',            'independt' ),
        'not_found'          => __( 'No replies found',          'independt' ),
        'not_found_in_trash' => __( 'No replies found in Trash', 'independt' ),
        'parent_item_colon'  => __( 'Topic:',                    'independt' )
    );

    // Reply rewrite
    $post_type['rewrite'] = array(
        'slug'       => "replies",
        'with_front' => false
    );

    // Reply supports
    $post_type['supports'] = array(
        'title',
        'editor',
        'revisions',
        'comments'
    );

    // Register reply content type
    register_post_type(
        'indqa_replies',
        array(
            'labels'              => $post_type['labels'],
            'rewrite'             => $post_type['rewrite'],
            'supports'            => $post_type['supports'],
            'description'         => __( 'Independt Q&A Replies', 'independt' ),
            'capabilities'        => indqa_get_topics_caps(),
            'capability_type'     => array( 'reply', 'replies' ),
            'menu_position'       => 555555,
            'exclude_from_search' => true,
            'has_archive'         => false,
            'show_in_nav_menus'   => false,
            'public'              => true,
            'show_ui'             => true,
            'can_export'          => true,
            'hierarchical'        => false,
            'query_var'           => true,
            'menu_icon'           => ''
        )
    );
}


function indqa_register_post_statuses() {

    // Closed
    register_post_status(
        'indqa_closed',
        array(
            'label'             => _x( 'Closed', 'post', 'independt' ),
            'label_count'       => _nx_noop( 'Closed <span class="count">(%s)</span>', 'Closed <span class="count">(%s)</span>', 'independt' ),
            'public'            => true,
            'show_in_admin_all' => true
        )
    );

    // Spam
    register_post_status(
        'indqa_spam',
        array(
            'label'                     => _x( 'Spam', 'post', 'independt' ),
            'label_count'               => _nx_noop( 'Spam <span class="count">(%s)</span>', 'Spam <span class="count">(%s)</span>', 'independt' ),
            'protected'                 => true,
            'exclude_from_search'       => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => false
        )
    );

    // Orphan
    register_post_status(
        'indqa_orphan',
        array(
            'label'                     => _x( 'Orphan', 'post', 'independt' ),
            'label_count'               => _nx_noop( 'Orphan <span class="count">(%s)</span>', 'Orphans <span class="count">(%s)</span>', 'independt' ),
            'protected'                 => true,
            'exclude_from_search'       => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => false
        )
    );

    // Hidden
    register_post_status(
        'indqa_hidden',
        array(
            'label'                     => _x( 'Hidden', 'post', 'independt' ),
            'label_count'               => _nx_noop( 'Hidden <span class="count">(%s)</span>', 'Hidden <span class="count">(%s)</span>', 'independt' ),
            'private'                   => true,
            'exclude_from_search'       => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => true
        )
    );

    /**
     * Trash fix
     *
     * We need to remove the internal arg and change that to
     * protected so that the users with 'view_trash' cap can view
     * single trashed topics/replies in the front-end as wp_query
     * doesn't allow any hack for the trashed topics to be viewed.
     */


    global $wp_post_statuses;

    if ( !empty( $wp_post_statuses['trash'] ) ) {

        // User can view trash so set internal to false
        if ( current_user_can( 'view_trash' ) ) {
            $wp_post_statuses['trash']->internal  = false;
            $wp_post_statuses['trash']->protected = true;

            // User cannot view trash so set internal to true
        } elseif ( !current_user_can( 'view_trash' ) ) {
            $wp_post_statuses['trash']->internal = true;
        }
    }

}

function indqa_register_taxonomies() {


    // Define local variable(s)
    $topic_tag = array();

    // Topic tag labels
    $topic_tag['labels'] = array(
        'name'          => __( 'Topic Tags',     'independt' ),
        'singular_name' => __( 'Topic Tag',      'independt' ),
        'search_items'  => __( 'Search Tags',    'independt' ),
        'popular_items' => __( 'Popular Tags',   'independt' ),
        'all_items'     => __( 'All Tags',       'independt' ),
        'edit_item'     => __( 'Edit Tag',       'independt' ),
        'update_item'   => __( 'Update Tag',     'independt' ),
        'add_new_item'  => __( 'Add New Tag',    'independt' ),
        'new_item_name' => __( 'New Tag Name',   'independt' ),
        'view_item'     => __( 'View Topic Tag', 'independt' )
    );

    // Topic tag rewrite
    $topic_tag['rewrite'] = array(
        'slug'       => 'topic-tags',
        'with_front' => false
    );

    // Register the topic tag taxonomy
    register_taxonomy(
        'indqa_topic_tags',
        'indqa_topics',
        array(
            'labels'                => $topic_tag['labels'],
            'rewrite'               => $topic_tag['rewrite'],
            'capabilities'          => indqa_get_topics_caps(),
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'show_tagcloud'         => true,
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true
        )
    );

}

function indqa_get_topics_caps() {
    $caps = array ( 'edit_posts'          => 'edit_indqa_topics',
        'edit_others_posts'   => 'edit_indqa_others_topics',
        'publish_posts'       => 'publish_indqa_topics',
        'read_private_posts'  => 'read_indqa_private_topics',
        'read_hidden_posts'   => 'read_indqa_hidden_topics',
        'delete_posts'        => 'delete_indqa_topics',
        'edit_post'           => 'edit_indqa_post',
        'delete_post'         => 'delete_indqa_post',
        'read_post'           => 'read_indqa_post',
        'delete_others_posts' => 'delete_indqa_others_topics');
    return $caps;
}