<?php

class Banner {
    private $post;
    private $title;
    private $description;
    private $altText = '';
    private $showTitle = false;
    private $showDescription = false;
    private $showIndicator = false;
    public static $activeClass = 'active';
    private $thumbnail = false;

    function __construct($post, $showTitle = false, $showDesc = false, $showIndicator= false) {
        $this->post = $post;
        $this->showTitle = $showTitle;
        $this->showDescription = $showDesc;
        $this->showIndicator = $showIndicator;
        $this->setThumbnail();
        $this->setAttributes();
    }

    private function setThumbnail() {
        $post = $this->post;
        $thumbnail_id = get_post_thumbnail_id($post->ID);
        $thumbnail = get_post($thumbnail_id);

        $this->thumbnail = $thumbnail;
    }

    private function setAttributes() {
        $thumbnail = $this->thumbnail;

        if ($thumbnail) {
            $this->title = $thumbnail->post_title;
            $this->description = $thumbnail->post_content;
            $this->altText = $thumbnail->post_excerpt;
        }
    }

    private function getThumbnailURL(){
        $post = $this->post;
        $thumbnailURL = get_the_post_thumbnail_url($post, 'banner_post_type_desktop');

        return $thumbnailURL;
    }

    private function renderImage() {
        $thumbnailURL = $this->getThumbnailURL();
        $altText = $this->altText;
        $image = '<img class="d-block w-100" src="%s" alt="%s" />';
        $image = sprintf($image, $thumbnailURL, $altText);

        return $image;
    }

    private function renderCaptions($withCaption) {
        $caption = '';

        if ($this->thumbnail && $withCaption) {
            $caption = '<div class="carousel-caption d-none d-md-block"><div class="containerCaption"><h3>%s</h3><p>%s</p></div></div>';
            $caption = sprintf($caption, $this->title, $this->description);
        }

        return $caption;
    }

    public function render($isActived = false, $withCaptions = true) {
        $active = $isActived ? self::$activeClass : '';
        $container = '<div class="carousel-item %s">%s%s</div>';
        $image = $this->renderImage();
        $caption = $this->renderCaptions($withCaptions);
        $container = sprintf($container, $active, $image, $caption);

        return $container;
    }
}

class BannerManager {
    private $banners;
    private $hasControls = true;
    private $hasIndicators = true;
    private $hasCaptions = true;
    private $bannerId;

    function __construct() {
        $this->banners = array();
        $this->bannerId = time();
    }

    public function showControls($active) {
        $this->hasControls = $active;
    }

    public function showIndicators($active) {
        $this->hasIndicators = $active;
    }

    public function showCaptions($active) {
        $this->hasCaptions = $active;
    }

    public function addBanner(Banner $banner) {
        array_push($this->banners, $banner);
    }

    private function renderControls() {
        $controls = '';

        if (!$this->hasControls) {
            return $controls;
        }

        $controls = "<a class='carousel-control-prev' href='#{$this->bannerId}' role='button' data-slide='prev'>
                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                        <span class='sr-only'>Previous</span>
                    </a>
                    <a class='carousel-control-next' href='#{$this->bannerId}' role='button' data-slide='next'>
                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                        <span class='sr-only'>Next</span>
                    </a>";
        return $controls;
    }

    private function renderIndicators() {
        $indicators = '';

        if (!$this->hasIndicators) {
            return $indicators;
        }

        $indicators = array('<ol class="carousel-indicators">');

        foreach($this->banners as $index => $banner) {
            $className = $index === 0 ? Banner::$activeClass : '';
            $li = "<li data-target='#{$this->bannerId}' data-slide-to='{$index}' class='{$className}'></li>";
            array_push($indicators, $li);
        }
        
        array_push($indicators, '</ol>');
        $indicators = implode('', $indicators);

        return $indicators;
    }

    public function render() {
        $banners = $this->banners;

        if (sizeof($banners) === 0) {
            return null;
        }

        echo "<div id='{$this->bannerId}' class='carousel slide' data-ride='carousel'>";
        echo $this->renderIndicators();

            foreach($banners as $index => $banner) {
                $isActived = $index === 0 ? true : false;
                echo $banner->render($isActived, $this->hasCaptions);
            }

        echo $this->renderControls();           
        echo "</div>";
    }
}

class AntoursBanners {
    private $resources;
    private $bannerID;
    private $itemClass;
    private $captionCss;
    private $imgCss;

    function __construct($resources, $id = false, $imgCss = array(), $itemCss = array(), $captionCss = array()) {
        $defaultID = "at_banner_" . time();
        $this->resources = $resources;
        $this->bannerID = $id ? $id : $defaultID;
        $this->itemCss = $itemCss;
        $this->captionCss = $captionCss;
        $this->imgCss = $imgCss;
    }

    public function render($indicators = false, $captions = false, $controls = true) {
        $banner = "<div id='$this->bannerID' class='carousel slide' data-ride='false'>";

        if (count($this->resources) < 2) {
            $controls = false;
            $indicators = false;
        }

        // render indicators if needed
        if ($indicators) {
            $banner .= $this->renderIndicators();
        }

        // render each image
        $resources = $this->renderBanners($captions);
        // add images to banner html
        $banner .= $resources;

        if ($controls) {
            $banner .= $this->renderControls();
        }

        $banner .= "</div>";

        echo $banner;
    }

    private function renderIndicators() {
        $index = 0;
        $id = $this->bannerID;
        $indicators = "<ol class='carousel-indicators'>";

        foreach($this->resources as $key => $resource) {
            $active = $index === 0 ? 'active' : '';
            $indicator = "<li data-target='#$id' data-slide-to='$index' class='$active'></li>";
            $indicators .= $indicator;
            $index++;
        }

        $indicators .= "</ol>";

        return $indicators;
    }

    private function getThumbnailPost() {
        $thumbnail_id = get_post_thumbnail_id();
        $thumbnail_post = get_post($thumbnail_id);

        return $thumbnail_post;
    }

    private function renderBanners($captions) {
        $index = 0;
        $banners = array("<div class='carousel-inner' role='listbox'>");
        
        foreach($this->resources as $picture) {
            var_dump($this->getThumbnailPost());
            $active = $index === 0 ? 'active' : '';

            $item = "<div class='carousel-item $active'>";
            $item .= $picture;
            $item .= "</div>";

            array_push($banners, $item);

            $index++;
        }

        array_push($banners, "</div>");

        $banners = implode("", $banners);

        return $banners;
    }

    private function renderControls() {
        $controls = '
            <a class="carousel-control-prev" href="#' . $this->bannerID . '" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#' . $this->bannerID . '" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        ';

        return $controls;
    }
}