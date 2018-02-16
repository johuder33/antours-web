<?php

require(get_template_directory() . "/system/utils.php");
/**
 * Send email by contact form - front end page
 */

add_action( 'wp_ajax_nopriv_' . $contactActionName, $contactActionName );
add_action( 'wp_ajax_' . $contactActionName, $contactActionName );

function send_notification_contact_form() {
    global $domain, $nonceRequest, $translation;
    $required = array('name', 'lastname', 'email', 'subject', 'message');

    try {
        // check for missing required fiels
        checkFields($_POST, $required);
        $nonce = $_POST['nonce'];

        // check if nonce field is correctly defined
        $isCorrectNonce = wp_verify_nonce($nonce, $nonceRequest);

        if (!$isCorrectNonce) {
            throw new Exception("Your request is unsecure, please confirm your requesting from secure domain");
        }

        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        checkTypeFields(array('email' => $email), array('email' => array('validator' => FILTER_VALIDATE_EMAIL)));

        $receivers = AntoursContactPage::getOptionOf(AntoursContactPage::$emailFieldName);

        if (isset($receivers) && is_array($receivers)) {
            $receivers = $receivers;
        } else {
            $receivers = array();
        }

        $adminEmail = get_bloginfo('admin_email');
        $adminEmail = (isset($adminEmail) && is_string($adminEmail)) ? array($adminEmail) : array();

        $receivers = array_merge($receivers, $adminEmail);

        if (count($receivers) === 0) {
            throw new Exception("A general error ocurrered");
        }

        $messageToAdmin = $message;

        $mailToAdmin = new Mail($receivers, $translation['ADMIN_MAIL_SUBJECT_CONTACT'], $messageToAdmin);
        $mailToAdmin->setNamespace('contact_admin');
        // set attributes for email template
        $attributes = makeAdminAttributes();
        $mailToAdmin->setAttributes($attributes);

        $mailToCustomer = new Mail($email, $translation['CUSTOMER_MAIL_SUBJECT_CONTACT'], $message);
        $mailToCustomer->setNamespace('contact_customer');
        // set attributes for customer email template
        $customerAttributes = makeCustomerAttributes();
        $mailToCustomer->setAttributes($customerAttributes);

        // send emails
        $adminEmailSent = call_user_func_array('wp_mail', $mailToAdmin->getEmail());
        $customerEmailSent = call_user_func_array('wp_mail', $mailToCustomer->getEmail());

        if (!$adminEmailSent && !$customerEmailSent) {
            throw new Exception('Emails were not sent');
        }

        $response = array(
            'sent' => true
        );

        wp_send_json_success($response);
    } catch(Exception $error) {
        // set the HTTP error code as a bad request code
        status_header(400);
        wp_send_json_error($error->getMessage());
    }

    wp_die();
}

/**
 * Load comments service
 */
add_action( 'wp_ajax_nopriv_' . $commentsActionName, $commentsActionName );
add_action( 'wp_ajax_' . $commentsActionName, $commentsActionName );

function get_more_comments() {
    global $nonceRequest;
    $commentLimit = get_option( 'posts_per_page' );
	$postID =  $_POST['post_id'];
    $nonce = $_POST['nonce'];
    $page =  $_POST['page'];
    $perPage = $commentLimit;

    if (isset($nonce) && isset($postID) && isset($page)) {
        $isCorrectNonce = wp_verify_nonce($nonce, $nonceRequest);
        if ($isCorrectNonce) {
            $comments = get_comments(array('number' => $commentLimit, 'offset' => ($page * $perPage), 'order' => 'DESC' ));

            if (count($comments) > 0) {
                $total = get_comments_number($postID);

                $results = array();
                foreach($comments as $comment) {
                    $currentComment = load_template_part($comment, "content-comment.php");
                    array_push($results, $currentComment);
                }

                $haveMore = ($page + 1) < ceil($total / $perPage) ? true : false;

                $response = array(
                    'comments' => $results,
                    'more' => $haveMore,
                    'total' => $total
                );

                wp_send_json_success($response);
            } else {
                $error = WP_Error(404, 'no more comments to this post');
                wp_send_json_error($error);
            }
        }
    }

    $error = WP_Error(400, 'some fields are missing');
    wp_send_json_error($error);

    wp_die();
}

/**
 * Get featured packages via ajax
 */
add_action( 'wp_ajax_nopriv_' . $featuredPackagesActionName, $featuredPackagesActionName );
add_action( 'wp_ajax_' . $featuredPackagesActionName, $featuredPackagesActionName );

function makeProductWidget() {
    return '<div class="product-widget col col-12 col-sm-6 col-md-4 col-lg-4">' . load_template_part($post, 'content-product.php') . '</div>';
}

function renderEmptySearch() {
    $searchQuery = 'Category this';
    return load_template_part($searchQuery, 'content-product-empty.php');
}

function get_featured_packages() {
    global $nonceRequest;
    $nonce = $_POST['nonce'];
    $category = $_POST['category'];
    $status_code = 200;
    
    try {
        if(!isset($category)) {
            throw new Exception('Category attribute is required');
        }
        
        $posts = loadProductsFromCategory($category);
        
        status_header($status_code);
        wp_send_json_success($posts);
    } catch (Exception $error) {
        $status_code = 400;
        status_header($status_code);
        wp_send_json_error($error->getMessage());
    }
    
    wp_die();
}

/**
 * Set reservation package from website
 */
add_action( 'wp_ajax_nopriv_' . $packageReservationActionName, $packageReservationActionName );
add_action( 'wp_ajax_' . $packageReservationActionName, $packageReservationActionName );

function save_package_reservation() {
    global $nonceRequest, $wpdb, $domain, $translation, $metabox_prefix;

    try {
        $nonce = $_POST['nonce'];

        if (!class_exists('Reservation_Booking')) {
            throw new Exception($translation['CLASS_RESERVATION_UNDEFINED_ERROR_MESSAGE']);
        }

        if (!isset($nonce)) {
            throw new Exception($translation['RESERVATION_NONCE_UNDEFINED_ERROR_MESSAGE']);
        }

        $isCorrectNonce = wp_verify_nonce($nonce, $nonceRequest);

        if (!$isCorrectNonce) {
            throw new Exception($translation['RESERVATION_NONCE_INCORRECT_ERROR_MESSAGE']);
        }

        $fullname = $_POST['fullname'];
        $typeId = $_POST['id_type'];
        $idNumber = $_POST['id_number'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $amount_passenger = $_POST['passengers'];
        $address = $_POST['hotel_address'];
        $packageId = $_POST['postId'];

        if (!isset($typeId) || !isset($packageId) || !isset($fullname) || !isset($idNumber) || !isset($email) || !isset($amount_passenger)){
            throw new Exception($translation['RESERVATION_SOME_FIELDS_MISSING_ERROR_MESSAGE']);
        }

        if (!is_numeric($packageId)) {
            throw new Exception($translation['RESERVATION_PACKAGE_ID_ERROR_MESSAGE']);
        }

        // check if post really exists
        $package = postExists($packageId);
        if (!$package) {
            throw new Exception("Your post is not available");
        }

        if ($typeId === 'rut' && !is_numeric($idNumber)) {
            throw new Exception($translation['RESERVATION_CUSTOMER_ID_ERROR_MESSAGE']);
        }

        if (!is_numeric($amount_passenger)) {
            throw new Exception($translation['RESERVATION_PASSENGERS_ERROR_MESSAGE']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception($translation['RESERVATION_CUSTOMER_EMAIL_ERROR_MESSAGE']);
        }

        $price = rwmb_meta($metabox_prefix.'trip_price_package', null, $packageId);
        $thumbnail_url = get_the_post_thumbnail_url($packageId);

        // cast postId to be an integer
        $packageId = intval($packageId);

        $ReservationManager = new Reservation_Booking($wpdb);
        $paramsGenerated['id_package'] = $packageId;
        $paramsGenerated['customer_fullname'] = $fullname;
        $paramsGenerated['customer_rut'] = $idNumber;
        $paramsGenerated['customer_phone'] = $telephone;
        $paramsGenerated['customer_email'] = $email;
        $paramsGenerated['amount_passenger'] = $amount_passenger;

        $isSaved = $ReservationManager->save($paramsGenerated);

        if (!$isSaved) {
            throw new Exception($translation['RESERVATION_FAILS_ERROR_MESSAGE']);
        }

        $reservation_id = $isSaved;

        // send emails
        $receivers = AntoursContactPage::getOptionOf(AntoursContactPage::$emailFieldName);
        $telephones = AntoursContactPage::getTelephones();

        if (isset($receivers) && is_array($receivers)) {
            $receivers = $receivers;
        } else {
            $receivers = array();
        }

        $adminEmail = get_bloginfo('admin_email');
        $adminEmail = (isset($adminEmail) && is_string($adminEmail)) ? array($adminEmail) : array();

        $receivers = array_merge($receivers, $adminEmail);

        // Set email notification for admin
        $mailToAdmin = new Mail($receivers, $translation['ADMIN_MAIL_SUBJECT_CONTACT'], 'My menssage');
        $mailToAdmin->setNamespace('reservation_admin');

        // make vars with text already translated
        $packageTitle = makeTranslationWithParams('RESERVATION_PACKAGE_TITLE', array('title' => $package->post_title));
        $packagePrice = makeTranslationWithParams('RESERVATION_PACKAGE_PRICE', array('price' => $price));
        $reservationAddress = makeTranslationWithParams('RESERVATION_PACKAGE_ADDRESS', array('address' => $address));
        $docType = makeTranslationWithParams('RESERVATION_PACKAGE_DOC_TYPE', array('docType' => $typeId));
        $customerDocId = makeTranslationWithParams('RESERVATION_PACKAGE_ID_NUMBER', array('docType' => $idNumber));
        $customerMessage = makeTranslationWithParams('RESERVATION_PACKAGE_CUSTOMER_MESSAGE', array('name' => $fullname));
        $customerName = makeTranslationWithParams('RESERVATION_CUSTOMER_FULLNAME', array('name' => $fullname));
        $slogan = makeTranslationWithParams('RESERVATION_SLOGAN_MAIL');
        $reservationId = makeTranslationWithParams('RESERVATION_ID', array('id' => $reservation_id));

        $telephones = implode(', ', $telephones);

        $adminAttributes = array(
            'PACKAGE' => $packageTitle,
            'PRICE' => $packagePrice,
            'ADDRESS' => $reservationAddress,
            'TYPE_DOC' => $docType,
            'ID_NUMBER' => $customerDocId,
            'FULLNAME' => $customerName,
            'YEAR' => date('d/m/Y'),
            'PHONES' => $telephones,
            'SLOGAN' => 'Antours Slogan',
            'MESSAGE' => 'Un mensage',
            'LOGO_URL' => $thumbnail_url,
            'RESERVATION_ID' => $reservationId
        );
        $mailToAdmin->setAttributes($adminAttributes);

        // Set email notification for customer
        $mailToCustomer = new Mail($email, $translation['RESERVATION_SUBJECT_EMAIL_CUSTOMER'], 'My menssage customer');
        $mailToCustomer->setNamespace('reservation_customer');

        $customerAttributes = array(
            'PACKAGE' => $packageTitle,
            'PRICE' => $packagePrice,
            'FULLNAME' => $customerName,
            'YEAR' => date('d/m/Y'),
            'PHONES' => $telephones,
            'SLOGAN' => 'Antours Slogan',
            'LOGO_URL' => $thumbnail_url,
            'RESERVATION_ID' => $reservationId
        );
        $mailToCustomer->setAttributes($customerAttributes);

        $adminEmailSent = call_user_func_array('wp_mail', $mailToAdmin->getEmail());
        $customerEmailSent = call_user_func_array('wp_mail', $mailToCustomer->getEmail());

        wp_send_json_success(array('mail' => array('sent' => array('customer' => $customerEmailSent, 'admin' => $adminEmailSent))));
    } catch (Exception $error) {
        status_header(400);
        wp_send_json_error($error->getMessage());
    }

    wp_die();
}

add_action( 'wp_ajax_nopriv_' . $communeActionName, $communeActionName );
add_action( 'wp_ajax_' . $communeActionName, $communeActionName );

function get_commune_by_city() {
    global $nonceRequest, $translation;
    $nonce = $_POST['nonce'];
    $cityId = $_POST['cityId'];

    try {
        if (!isset($nonce)) {
            throw new Exception($translation['RESERVATION_NONCE_UNDEFINED_ERROR_MESSAGE']);
        }

        $isCorrectNonce = wp_verify_nonce($nonce, $nonceRequest);

        if (!$isCorrectNonce) {
            throw new Exception($translation['RESERVATION_NONCE_INCORRECT_ERROR_MESSAGE']);
        }

        $result = call_booking_method('getCommuneByCityId', $cityId);

        if (!$result) {
            throw new Exception("not results found");
        }

        wp_send_json_success($result);
    } catch (Exception $error) {
        status_header(400);
        wp_send_json_error($error->getMessage());
    }

    wp_die();
}

add_action( 'wp_ajax_nopriv_' . $servicesByCommuneActionName, $servicesByCommuneActionName );
add_action( 'wp_ajax_' . $servicesByCommuneActionName, $servicesByCommuneActionName );

function get_services_by_commune() {
    global $nonceRequest, $translation;
    $nonce = $_POST['nonce'];
    $communeId = $_POST['communeId'];

    try {
        if (!isset($nonce)) {
            throw new Exception($translation['RESERVATION_NONCE_UNDEFINED_ERROR_MESSAGE']);
        }

        $isCorrectNonce = wp_verify_nonce($nonce, $nonceRequest);

        if (!$isCorrectNonce) {
            throw new Exception($translation['RESERVATION_NONCE_INCORRECT_ERROR_MESSAGE']);
        }

        $result = call_booking_method('getServicesByCommuneId', $communeId);

        if (!$result) {
            throw new Exception("not results found");
        }

        wp_send_json_success($result);
    } catch (Exception $error) {
        status_header(400);
        wp_send_json_error($error->getMessage());
    }

    wp_die();
}

add_action( 'wp_ajax_nopriv_' . $reservationActionName, $reservationActionName );
add_action( 'wp_ajax_' . $reservationActionName, $reservationActionName );

function set_reservation() {
    global $nonceRequest, $wpdb;
    $nonce = $_POST['nonce'];
    $communeId = $_POST['communeId'];
    $startFrom = $_POST['startFrom'];
    $isRoundTrip = $_POST['isRoundTrip'];
    $endTo = $_POST['endTo'];
    $departureDate = $_POST['departureDate'];
    $departureTime = $_POST['departureTime'];
    $returnDate = $_POST['returnDate'];
    $returnTime = $_POST['returnTime'];
    $passengers = $_POST['passengers'];
    $service_id = $_POST['service_id'];
    $passenger_fullname = $_POST['passenger_fullname'];
    $passenger_email = $_POST['passenger_email'];
    $passenger_phone = $_POST['passenger_phone'];
    $passenger_id = $_POST['passenger_id'];
    $passenger_id_mode = $_POST['passenger_id_mode'];
    $price = $_POST['price'];
    $data = array();

    try {
        if (!isset($nonce)) {
            throw new Exception($translation['RESERVATION_NONCE_UNDEFINED_ERROR_MESSAGE']);
        }

        $isCorrectNonce = wp_verify_nonce($nonce, $nonceRequest);

        if (!$isCorrectNonce) {
            throw new Exception($translation['RESERVATION_NONCE_INCORRECT_ERROR_MESSAGE']);
        }

        $communeId = trim($communeId);

        if (empty($communeId)) {
            throw new Exception("Commune id must to be defined");
        }

        if (!is_numeric($communeId)) {
            throw new Exception("Commune id must a number");
        }

        // add commune id
        $data['id_commune'] = $communeId;

        if (!isset($service_id) || empty(trim($service_id)) || !is_numeric($service_id)) {
            throw new Exception("Service need to be chosen");
        }

        $data['id_service'] = $service_id;

        // updated

        $data['price'] = floatval($price);

        $startFrom = trim($startFrom);

        if (empty($startFrom)) {
            throw new Exception("Street must to be defined");
        }

        $data['start_from'] = $startFrom;

        if (!isset($endTo) || empty(trim($endTo))) {
            throw new Exception("Destiny must to be defined");
        }

        $data['end_to'] = trim($endTo);

        $isRoundTrip = !is_null($isRoundTrip) ? json_decode($isRoundTrip) : null;

        if(!is_bool($isRoundTrip)) {
            throw new Exception("Is round trip must to be defined");
        }

        $data['is_round_trip'] = $isRoundTrip;

        if (empty($departureDate)) {
            throw new Exception("Departure date must be defined");
        }

        if (!is_numeric($departureDate)) {
            throw new Exception("Departure date must be a valid timestamp value");
        }

        $data['departure_date'] = getDateAs($departureDate, 'Y-m-d');

        if (empty($departureTime)) {
            throw new Exception("Departure time must be defined");
        }

        if (!is_numeric($departureTime)) {
            throw new Exception("Departure time must be a valid timestamp value");
        }

        $data['departure_time'] = getDateAs($departureTime, 'Y-m-d H:i:s');

        if ($isRoundTrip) {
            if (!isset($returnDate) || !isset($returnTime)) {
                throw new Exception("Return date and time must be defined");
            }

            if (empty($returnDate)) {
                throw new Exception("Return date must be defined");
            }

            if (!is_numeric($returnDate)) {
                throw new Exception("return date must be a valid timestamp value");
            }

            if (empty($returnTime)) {
                throw new Exception("Return time must be defined");
            }

            if (!is_numeric($returnTime)) {
                throw new Exception("return time must be a valid timestamp value");
            }

            $data['return_date'] = getDateAs($returnDate, 'Y-m-d');
            $data['return_time'] = getDateAs($returnTime, 'Y-m-d H:i:s');
        }

        if (empty($passenger_email)) {
            throw new Exception("passenger email must be defined");
        }

        if (!filter_var($passenger_email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("passenger email must be a valid email");
        }

        $data['main_passenger_email'] = $passenger_email;

        if (!isset($passenger_fullname)) {
            throw new Exception("passenger name must be defined");
        }

        $passenger_fullname = trim($passenger_fullname);

        if (empty($passenger_fullname)) {
            throw new Exception("passenger name must be defined");
        }

        $data['main_passenger_fullname'] = $passenger_fullname;

        if (!isset($passenger_id_mode)) {
            throw new Exception("passenger RUT or passport need to be defined");
        }

        $passenger_id_mode = strtolower($passenger_id_mode);

        if ($passenger_id_mode !== 'rut' && $passenger_id_mode !== 'passport') {
            throw new Exception("passenger RUT or passport need to be defined");
        }

        if (!isset($passenger_id) || empty(trim($passenger_id))) {
            throw new Exception("passenger ID must be defined");
        }

        $data['main_passenger_' . $passenger_id_mode] = $passenger_id;

        if (isset($passenger_phone) && !empty(trim($passenger_phone))) {
            if(!is_numeric($passenger_phone)) {
                throw new Exception("passenger phone must be a valid phone number");
            }

            $data['main_passenger_phone'] = $passenger_phone;
        }

        if (!isset($passengers)) {
            throw new Exception("passenger amount must to be defined");
        }

        if (intval($passengers) <= 0) {
            throw new Exception("passenger amount must to be defined");
        }

        $data['num_passenger'] = intval($passengers);

        $data['order_date'] = date("Y-m-d H:i:s");

        $result = call_booking_method('setReservation', $data);

        if ($result === false) {
            throw new Exception("unknown error occurred");
        }

        $toEmail = $data['main_passenger_email'];
        $subject = 'Notification reservacion de traslados';
        $content = array(
            'namespace' => 'taxi-booking-reservation',
            'data' => $data,
            'order_id' => $result['order_id']
        );

        // get commune name
        $commune = call_booking_method('getCommuneById', 109);
        if (!is_null($commune) && sizeof($commune) === 1) {
            $commune = $commune[0];
        }
        $commune = $commune->name;
        $startFrom = $commune->name;

        // Set email notification for customer
        $mailToCustomer = new Mail($passenger_email, $translation['RESERVATION_SUBJECT_EMAIL_CUSTOMER'], 'My menssage customer');
        $mailToCustomer->setNamespace('taxi_booking_customer');

        $customerAttributes = array(
            'MESSAGE' => 'My message booking',
            'YEAR' => date('Y'),
            'PHONES' => $telephones,
            'SLOGAN' => 'Antours Slogan',
            'LOGO_URL' => $thumbnail_url,
            'COMMUNE' => $commune,
            'START_FROM' => $startFrom,
            'END_TO' => $endTo,
            'ROUND_TRIP' => $isRoundTrip,
            'PASSANGERS' => $passengers,
            'PRICE' => $price,
            'PASSENGER_FULLNAME' => $passenger_fullname,
            'SERVICE_NAME' => $service_id,
            'DEPARTURE_DATE' => $departureDate,
            'DEPARTURE_TIME' => $departureTime,
            'RETURN_DATE' => $returnDate,
            'RETURN_TIME' => $returnTime
        );
        $mailToCustomer->setAttributes($customerAttributes);

        $emailSent = call_user_func_array('wp_mail', $mailToCustomer->getEmail());

        $result['email_sent'] = $emailSent;
        $result['customer'] = $customerAttributes;

        wp_send_json_success($result);
    } catch (Exception $error) {
        status_header(400);
        wp_send_json_error(json_decode($error->getMessage()));
    }

    wp_die();
}