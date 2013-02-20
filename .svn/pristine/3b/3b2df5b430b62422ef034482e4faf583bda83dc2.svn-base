<?php


/* -----------------------------------------------------------------------
 *
 *
 *                          VOTE
 *
 *
 * ----------------------------------------------------------------------- */


function indqa_post_voting_callback () {
    global $post;
    $my_vote = indqa_get_my_vote($post->ID);

        ?>
    <div class="your-vote <?php echo (!$my_vote OR $my_vote['avis'] == 0)?"hide":""; ?>">
        Vous avez voté <strong class="your-avis"><?php echo ($my_vote['avis'] == 1)?"Pour":"Contre"?></strong> le <span class="date"><?php echo $my_vote['date']; ?></span>.
    </div>
    <?php
    ?>
<div class="toolbox">
    <input name="vote" type="submit" class="button button-primary button-large" id="votefor" value="Voter pour" data-avis="1">
    <input name="vote" type="submit" class="button button-primary button-large" id="voteagainst" value="Voter contre" data-avis="-1"><br/>
    <a id="deletevote" data-avis="0">Supprimer son vote</a>
</div>
<div class="message">

</div>
<script>
    jQuery(document).ready(function($){
        $('#votefor, #voteagainst, #deletevote').click(function(){
            var data = {
                action: 'indqa_vote',
                vote_type: 'indqa_replies',
                post_id: $("#post_ID").val(),
                avis: $(this).data('avis')
            };

            jQuery.post(ajaxurl, data, function(response) {
                var response = jQuery.parseJSON(response);
                if(response.result) {

                    if(response.explain.avis == 0) $("#indqa_box_voting_topic .your-vote").hide();
                    else {
                        var avis = "";
                        if(response.explain.avis == 1) avis = "Pour";
                        else avis = "Contre";

                        $("#indqa_box_voting_topic .your-vote .your-avis").html(avis);
                        $("#indqa_box_voting_topic .your-vote .date").html(response.explain.date);
                        $("#indqa_box_voting_topic .your-vote").removeClass('hide');
                        $("#indqa_box_voting_topic .your-vote").show();
                    }
                } else {
                    $("#indqa_box_voting_topic .message").html('Une erreur est survenue.');
                }
            });
            return false;
        });
    });
</script>
<?php
}

