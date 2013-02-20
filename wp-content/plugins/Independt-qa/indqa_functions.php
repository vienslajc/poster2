<?php

/* -----------------------------------------------------------------------
 *
 *
 *                          VOTE
 *
 *
 * ----------------------------------------------------------------------- */

function indqa_add_vote ($post_id, $avis = 0) {
    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) {
        return false;
    } else {
        $element = get_post($post_id);

        if($element) {
            $votes = get_post_meta ($element->ID, '_indqa_votes', false);

            $sortie = array('user_id' => $current_user->ID, 'avis' => $avis, 'date' => date('Y-m-d H:i:s'));

            if(count($votes) > 0) {
                foreach($votes as $vote) {
                    if($vote['user_id'] == $current_user->ID) {
                        if($vote['avis'] != $avis && update_post_meta($element->ID, '_indqa_votes', $sortie, $vote)) {
                            if($avis == 0 && $vote['avis'] == 1) $avis = -1;
                            else if($avis == 0 && $vote['avis'] == -1) $avis = 1;
                            indqa_edit_user_reputation($element->post_author, $avis);
                            return true;
                        } else {
                            return false;
                        }
                    }
                }

                if(add_post_meta($element->ID, '_indqa_votes', $sortie)) {
                    indqa_edit_user_reputation($element->post_author, $avis);
                    return true;
                } else {
                    return false;
                }
            } else {
                if(update_post_meta($element->ID, '_indqa_votes', $sortie)) {
                    indqa_edit_user_reputation($element->post_author, $avis);
                    return true;
                } else {
                    return false;
                }
            }

        } else {
            return false;
        }

    }
}

function indqa_edit_user_reputation ($user_id, $vote) {
    $reputation = get_user_meta($user_id,'_indqa_reputation',true);
    if(!$reputation) $reputation = 0;
    update_user_meta( $user_id, '_indqa_reputation', $reputation + $vote );
}

/*
 * All, 1(pour) ou -1 (contre)
 */
function indqa_get_votes ($post_id, $type = "all") {
    $votes = get_post_meta ($post_id, '_indqa_votes', false);

    if(count($votes) > 0) {
        if($type == "all") {
            return $votes;
        } else {
            $sortie = array();
            foreach($votes as $vote) {
                if($vote['avis'] == $type ) {
                    array_push($sortie, $vote);
                }
            }

            if(count($sortie) > 0) return $sortie;
            else return false;
        }
    } else {
        return false;
    }
}

function indqa_get_my_vote ($post_id) {
    $current_user = wp_get_current_user();

    if ( 0 == $current_user->ID )
        return false;

    $votes = get_post_meta ($post_id, '_indqa_votes', false);

    if(count($votes) > 0) {
        foreach($votes as $vote) {
            if($vote['user_id'] == $current_user->ID ) {
                return $vote;
            }
        }
    } else {
        return false;
    }
}

//* -------------------- AJAX

if( is_admin() ) add_action('wp_ajax_indqa_vote', 'indqa_ajax_vote_callback');

function indqa_ajax_vote_callback() {
    global $wpdb;

    if(isset($_POST['avis']) && isset($_POST['post_id'])) {
        $avis = $_POST['avis'];
        $post_id = $_POST['post_id'];

        $result = null;

        if(indqa_add_vote($post_id, $avis)) {
            $result = array('result'=>'true', 'explain' => array('avis' => $avis, 'date' => date('Y-m-d H:i:s')));
        } else {
            $result = array('result'=>'false');
        }

        echo json_encode($result);
    } else {
        $result = array('result'=>'false', 'explain' => 'Erreur dans les variables envoyées.');
        echo json_encode($result);
    }

    die(); // this is required to return a proper result
}


/* -----------------------------------------------------------------------
 *
 *
 *                          FOLLOW TOPIC
 *
 *
 * ----------------------------------------------------------------------- */


/* -----------------------------------------------------------------------
 *
 *
 *                          LANGUAGES
 *
 *
 * ----------------------------------------------------------------------- */


// load language files
function indqa_set_lang_file() {
    # set the language file
    $currentLocale = get_locale();
    if(!empty($currentLocale)) {
        $moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
        if (@file_exists($moFile) && is_readable($moFile)) {
            load_textdomain(EMU2_I18N_DOMAIN, $moFile);
        }

    }
}