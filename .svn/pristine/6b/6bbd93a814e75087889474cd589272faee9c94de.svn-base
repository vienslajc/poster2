<?php


function indqa_add_topic_boxes() {
    add_meta_box( 'indqa_box_parent_topic', 'Topic rattaché', 'indqa_topic_box_callback', 'indqa_replies', 'side','high');
    add_meta_box( 'indqa_box_voting_topic', 'Votes', 'indqa_post_voting_callback', 'indqa_replies', 'side','low');
}

/* -----------------------------------------------------------------------
 *
 *
 *  Permet d'ajouter une box de visualisation et selection du topic parent
 *
 *
 * ----------------------------------------------------------------------- */

function indqa_topic_box_callback () {
    global $post;

    $parent_id = $post->post_parent;

    // Parent ID déjà assigné

    if(isset($parent_id) && is_numeric($parent_id) && $parent_id != 0) {
        $post_parent_title = get_the_title($parent_id);
        ?>
    <div class="wrap-box">
        <div class="message">
            Cette réponse est relié au post : <br/>
            <a href="<?php echo get_admin_url(); ?>post.php?post=<?php echo $parent_id; ?>&action=edit"><strong><?php echo $post_parent_title; ?> (<?php echo $parent_id; ?>)</strong></a>
        </div>
        <div class="tools">
            <div class="parent-choose">
                <label>ID du topic parent : </label>
                <input type="text" id="indqa_parent_id" name="indqa_parent_id" value="<?php echo $parent_id; ?>" />
                <input type="hidden" name="indqa_parent_id_noncename" value="<?php echo wp_create_nonce(__FILE__); ?>" />
            </div>
        </div>
    </div>
    <?php
    }

    // Parent non encore assigné

    else {

        ?>
    <div class="wrap-box">
        <div class="message">
            Vous n'avez pas encore assigné de topic parent à cette réponse !
        </div>
        <div class="tools">
            <div class="parent-choose">
                <label>Entre l'ID du topic parent : </label>
                <input type="text" id="indqa_parent_id" name="indqa_parent_id" value="<?php echo (isset($_GET['indqa_parent_post']))?$_GET['indqa_parent_post']:""; ?>" />
            </div>
        </div>
    </div>
    <?php

    }
}

function indqa_topic_box_save($post_id) {

    if (empty ($_POST) || !$post_id || (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ))
        return;

    if(isset($_POST['indqa_parent_id']) && ($_POST['post_type'] == "indqa_replies") && !wp_is_post_revision( $post_id ) && is_numeric($_POST['indqa_parent_id'])) {

        remove_action('save_post', 'indqa_topic_box_save');

        wp_update_post(array('ID' => $post_id, 'post_parent' => $_POST['indqa_parent_id']));

        add_action('save_post', 'indqa_topic_box_save');

    }

}

add_action("save_post", "indqa_topic_box_save");