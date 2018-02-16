<?php
global $translation;
$logo_url = loadAssetFromResourceDirectory("images", "antours-logo.png");
$progressText = $translation['CONTACT_BTN_LOADING'];
$defaultText = $translation['CONTACT_BTN_LOAD'];
$sentText = $translation['CONTACT_BTN_SENT'];
$notSentText = $translation['CONTACT_BTN_NOT_SENT'];

$fieldNameError = $translation['CONTACT_FORM_FIELD_NAME_ERROR'];
$fieldLastnameError = $translation['CONTACT_FORM_FIELD_LASTNAME_ERROR'];
$fieldEmailError = $translation['CONTACT_FORM_FIELD_EMAIL_ERROR'];
$fieldSubjectError = $translation['CONTACT_FORM_FIELD_SUBJECT_ERROR'];
$fieldMessageError = $translation['CONTACT_FORM_FIELD_MESSAGE_ERROR'];
?>

            <footer class="footer container-fluid">
                <div class="container" id="contact">
                    <div class="row">
                        <div class="row">
                            <div class="footer-information col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <figure class="footer-logo text-center text-md-left">
                                    <img src="<?php echo $logo_url; ?>" class="img-responsive" />
                                </figure>
                                <div class="text-justify text-md-left">
                                    <p>
                                        Para mayor información, comunicate con nuestros diseñadores de viaje y obtén una experiencia soñada.
                                    </p>

                                    <div class="contact-info-container">
                                        <?php
                                            AntoursContactPage::renderInformation();
                                        ?>
                                    </div>

                                    <div>
                                        <?php
                                            AntoursContactPage::getSocialNetworkLinks();
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="footer-form col">
                                <div class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong></strong>
                                </div>

                                <form class="form" id="contact-form">
                                    <div class="alert d-none block-notice" role="alert" data-sent="<?php echo $sentText; ?>" data-notsent="<?php echo $notSentText; ?>">
                                        <?php echo $sentText; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <input class="form-control contact-field" data-required="true" name="name" placeholder="<?php echo $translation['CONTACT_FORM_FIELD_NAME']; ?>" />
                                            <div class="invalid-feedback">
                                                <?php echo $fieldNameError; ?>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <input class="form-control contact-field" data-required="true" name="lastname" placeholder="<?php echo $translation['CONTACT_FORM_FIELD_LASTNAME']; ?>" />
                                            <div class="invalid-feedback">
                                                <?php echo $fieldLastnameError; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div>
                                                <input class="form-control contact-field" data-required="true" name="email" placeholder="<?php echo $translation['CONTACT_FORM_FIELD_EMAIL']; ?>" />
                                                <div class="invalid-feedback">
                                                    <?php echo $fieldEmailError; ?>
                                                </div>
                                            </div>

                                            <div>
                                                <input class="form-control contact-field" data-required="true" name="subject" placeholder="<?php echo $translation['CONTACT_FORM_FIELD_SUBJECT']; ?>" />
                                                <div class="invalid-feedback">
                                                    <?php echo $fieldSubjectError; ?>
                                                </div>
                                            </div>

                                            <div>
                                                <textarea class="form-control contact-field message-field" data-required="true" name="message" placeholder="<?php echo $translation['CONTACT_FORM_FIELD_MESSAGE']; ?>"></textarea>
                                                <div class="invalid-feedback">
                                                    <?php echo $fieldMessageError; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button id="contact-btn" class="btn btn-default text-uppercase" data-default="<?php echo $defaultText; ?>" data-progress="<?php echo $progressText; ?>" type="submit">
                                                <?php echo $defaultText; ?>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row copyright">
                    <div class="container copyright-container text-center">
                        <p>
                            Copyright @ 2017 Antours. Todos los derechos reservados
                        </p>
                    </div>
                </div>
                
            </footer> <!--END FOOTER-->

        </div> <!-- ROW -->
    </div> <!--FLUD CONTAINER END-->
    <?php wp_footer(); ?>
</body>
</html>