<?php
    $thumbnail = $resource['url'];
    $full = $resource['full_url'];
?>

<a class="gallery-thumbnail" data-fancybox="gallery" href="<?php echo $full ?>">
    <img src="<?php echo $thumbnail ?>" class="img-fluid" />
</a>