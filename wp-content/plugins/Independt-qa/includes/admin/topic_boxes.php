<?php

/*
 * Permet d'ajouter une box de visualisation et selection du topic parent
 */

function indqa_add_replie_boxes() {
    add_meta_box( 'indqa_box_child_replies', 'Réponses', 'indqa_replie_box_callback', 'indqa_topics', 'side','high');
    add_meta_box( 'indqa_box_voting_topic', 'Votes', 'indqa_post_voting_callback', 'indqa_topics', 'side','low');
}

function indqa_replie_box_callback() {
    global $post;
    $args = array(
        'numberposts' => -1,
        'order'=> 'ASC',
        'post_parent' => $post->ID,
        'post_status' => 'publish',
        'post_type' => 'indqa_replies'
    );

    $replies = get_children( $args );

    ?>
        <div class="main-toolbox">
            <a href="<?php echo get_admin_url(); ?>post-new.php?post_type=indqa_replies&indqa_parent_post=<?php echo $post->ID; ?>">Ajouter une réponse</a>
        </div>
    <?php

    if(count($replies) > 1) {

        foreach ($replies as $replie) {
        ?>
        <table class="widefat fixed comments comments-box" cellspacing="0" style="">
            <tbody id="the-replie-list" data-wp-lists="list:replie">
            <tr id="replie-<?php echo $replie->ID; ?>" class="replie byuser even thread-even depth-1 approved" style="background-color: rgb(249, 249, 249);" data-replieId="<?php echo $replie->ID; ?>">
                <td class="author column-author">
                    <div class="user-avatar">
                            <?php echo bp_core_fetch_avatar ( array( 'item_id' => $replie->post_author, 'type' => 'thumb' ) ) ?></a>
                    </div>
                    <div class="user-name">
                        <strong><?php echo bp_core_get_user_displayname( $replie->post_author, true ) ?></strong>
                    </div>
                    <div class="submitted-on">
                        Envoyé le <?php echo $replie->post_date; ?>
                    </div>
                    <div>
                        <?php
                        $votes_pour = indqa_get_votes($replie->ID, 1);
                        $votes_contre = indqa_get_votes($replie->ID, -1);
                        ?>
                        Votes : <?php echo ($votes_pour)?count($votes_pour):"0"; ?> Pour et <?php echo ($votes_contre)?count($votes_contre):"0"; ?> Contre
                    </div>
                    <div class="content-replie">
                        <p><strong><?php echo $replie->post_title; ?></strong></p>
                        <p><?php echo $replie->post_content; ?></p>
                    </div>
                    <div class="row-actions">
                        <div class="edit">
                            <a href="<?php echo get_admin_url(); ?>post.php?post=<?php echo $replie->ID; ?>&action=edit">Éditer</a>
                        </div>

                    </span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <?php

        }
    } else {
        // Il n'y a pas encore de réponses à ce topic
        ?>
            Pas de réponses existante à ce topic !
        <?php
    }
}