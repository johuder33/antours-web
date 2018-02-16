<?php
    $videoURL = $resource;
    $videoThumbnail = getThumbnailURL($videoURL);
?>

<a class="gallery-thumbnail thumbnailVideo" data-fancybox="gallery" href="<?php echo $videoURL; ?>" style="background-image: url('<?php echo $videoThumbnail; ?>')">
    <i class="fa fa-play-circle play-icon" aria-hidden="true"></i>
</a>