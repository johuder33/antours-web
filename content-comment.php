<?php

$id = $comment->comment_ID."-".$comment->comment_post_ID."-comment";
// $author = $comment->comment_author;
$email = $comment->comment_author_email;
$content = $comment->comment_content;
$date = get_comment_date('D d, M, Y, H:i', $id);

?>

<div class="comment-single">
    <span class="comment-icon-container">
        <i class="fa fa-commenting defaultColor reverseFlip"></i>
    </span>
    
    <div id="<?php echo $id; ?>" class="comment-single-container">
        <div id="comment-content">
            <div class="user-container">
                <div class="meta-data">
                    <span>
                        <i class="fa fa-user-circle defaultColor" aria-hidden="true"></i>
                    </span>
                    <!--<span>
                        <?php echo $author; ?>
                    </span>-->
                </div>

                <div class="meta-data">
                    <span>
                        <i class="glyphicon glyphicon-calendar defaultColor"></i>
                    </span>
                    <span>
                        <?php echo $date; ?>
                    <span>
                </div>
            </div>

            <div class="comment">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>