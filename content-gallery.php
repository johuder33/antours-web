<?php

global $translation;

$galleryTitle = $translation['CPT_PACKAGE_GALLERY_TITLE'];

// get all pictures from tour
$gallery = rwmb_meta('antours_mtx_trip_gallery_group');
// get all videos from tour
$videos = rwmb_get_value('antours_mtx_trip_video_group');

// mix the above resources
$items = array_merge($videos, $gallery);

if (count($items) <= 0 || empty($items)) {
    return;
}

?>

<div class="vertical-separator">
    <div>
        <h1 class="page-header page-header-package">
            <?php echo $galleryTitle; ?>
        </h1>
    </div>

    <div class="gallery-container text-center center-block">
        

        <div class="gallery-wrapper">
            <?php
                foreach($items as $id => $resource) {
                    $item = $resource;
                    if (is_array($resource)) {
                        include(locate_template("content-thumbnail.php"));
                    }
                    
                    if (is_string($resource)) {
                        include(locate_template("content-video.php"));
                    }
                }
            ?>
        </div>
    </div>
</div>