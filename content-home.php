<?php

global $home;

$arguments = array(
    'post_type' => $home,
    'post_status' => 'publish',
    'posts_per_page' => 1
);

$query = new WP_Query( $arguments );



?>

<?php
if ($query->have_posts()) {
    ?>
        <div class="container">
            <div class="row">
                <div class="text-justify">
                    <?php
                        while($query->have_posts()) {
                            $query->the_post();
                            $content = get_the_content();
                            $content = wpautop($content);
                            echo $content;
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php
}
?>