<?php

class Reservation {
    // let's make all our internal variables as privates
    // to avoiding let external code access and modify them.
    private $id;
    private $package_id;
    private $customer_fullname;
    private $customer_doc;
    private $customer_id;
    private $customer_phone;
    private $customer_email;
    private $customer_address;
    private $amount_passengers;

    public function __construct(
        $package_id,
        $fullname,
        $doc_type,
        $identificator,
        $phone,
        $passengers,
        $email,
        $address
    ) {
        // let's create the class with requires initial values
        $this->package_id = $package_id;
        $this->customer_fullname = $fullname;
        $this->customer_doc = $doc_type;
        $this->customer_id = $identificator;
        $this->customer_phone = $phone;
        $this->amount_passengers = $passengers;
        $this->customer_email = $email;
        $this->customer_address = $address;
    }

    public function save() {
        global $wpdb;
        $tablename = Configuration::getTableName();
        $values = $this->prepareAttributes();

        $saved = $wpdb->insert(
            $tablename,
            $values
        );

        if ($saved === false) {
            return $saved;
        }

        // let's store our new reservation into the current instance
        $this->setId($wpdb->insert_id);

        return true;
    }

    public function getReservationId() {
        return $this->id;
    }

    private function prepareAttributes() {
        $attributes = array(
            'package_id' => $this->package_id,
            'customer_fullname' => $this->customer_fullname,
            'customer_doc' => $this->customer_doc,
            'customer_id' => $this->customer_id,
            'customer_phone' => $this->customer_phone,
            'customer_email' => $this->customer_email,
            'customer_address' => $this->customer_address,
            'amount_passengers' => $this->amount_passengers
        );

        return $attributes;
    }

    private function setId($id) {
        $this->id = $id;
    }
}