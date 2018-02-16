<?php

global $wp_query, $category;
$total = $wp_query->found_posts;

?>

<button id="loader_posts" data-tax="<?php echo $category->term_id; ?>" data-count="<?php echo $total; ?>">Cargar mas posts</button>