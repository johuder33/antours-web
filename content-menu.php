<?php

global $languages, $about, $services, $packages, $translation;
$logo_url = loadAssetFromResourceDirectory("images", "antours-logo.png");
$site_url = get_site_url();

?>

<header class="container">
    <nav class="row align-items-center menu">
        <div class="col-12 col-sm-12 col-md-auto col-lg-auto col-xl-auto">
                <div class="logo">
                    <div id="btn-menu" class="d-md-none">
                        <i class="fa fa-bars fa-2x"></i>
                    </div>

                    <div class="container-logo text-center">
                        <a class="logo-link" href="<?php echo $site_url; ?>">
                            <img class="img-fluid" src="<?php echo $logo_url; ?>"/>
                        </a>
                    </div>

                    <div class="invisible d-md-none">
                        <i class="fa fa-bars fa-2x"></i>
                    </div>
                </div>
        </div>
        <div class="col-12 col-sm-12 col-md col-lg col-xl order-12 order-md-1 menu-list">
                <div class="row justify-content-center no-gutters">
                    <ul class="list-unstyled antours-menu-list">
                        <li class="text-uppercase d-md-inline-block d-lg-inline-block d-xl-inline-block">
                            <a href="<?php echo bloginfo('url') ?>/<?php echo $about; ?>" class="menu-link" data-href="at_nosotros">
                                <?php echo $translation['MENU_ITEM_ABOUT_US']; ?>
                            </a>
                        </li>
                        <li class="text-uppercase d-md-inline-block d-lg-inline-block d-xl-inline-block">
                            <a href="<?php echo bloginfo('url') ?>/<?php echo $packages; ?>" class="menu-link" data-href="at_paquetes">
                                <?php echo $translation['MENU_ITEM_TOURS']; ?>
                            </a>
                        </li>
                        <li class="text-uppercase d-md-inline-block d-lg-inline-block d-xl-inline-block">
                            <a href="<?php echo bloginfo('url') ?>/<?php echo $services; ?>" class="menu-link" data-href="at_servicios">
                                <?php echo $translation['MENU_ITEM_SERVICES']; ?>
                            </a>
                        </li>
                        <li class="text-uppercase d-md-inline-block d-lg-inline-block d-xl-inline-block">
                            <a href="#contact" class="menu-link" data-scrollable="true">
                                <?php echo $translation['MENU_ITEM_CONTACT']; ?>
                            </a>
                        </li>
                    </ul>
                </div>
        </div>
        <div class="col-12 col-sm-12 col-md-auto col-lg-auto col-xl-auto order-1 order-md-12">
            <div class="menu-lang">
                <i class="fa fa-bars lang-flag" aria-hidden="true"></i>
                <ul class="list-unstyled list-inline list-languages text-xs-center text-sm-center text-md-left">
                    <?php pll_the_languages(array('hide_current' => 1, 'show_flags' => 1)); ?>
                </ul>
            </div>
        </div>
    </nav>
</header>