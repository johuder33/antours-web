<?php

class Mail {
    public $namespace;
    public $to;
    public $subject;
    public $message;
    public $headers;
    public $attachments;
    private $templates;
    private $template;
    private $dir = '/emails/templates';
    private $attributes;

    public function __construct($to, $subject, $message, $headers = array('Content-Type: text/html; charset=UTF-8')) {
        if (!is_array($to)) {
            $to = array($to);
        }

        if (!is_array($headers)) {
            $headers = array($headers);
        }

        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
        $this->attachments = array();
        $this->attributes = array();
        $this->templates = $this->load_email_templates();
    }

    public function setNamespace($namespace) {
        $this->namespace = $namespace;
        $this->setTemplate();
    }

    public function addHeader($header) {
        array_push($this->headers, $header);
    }

    public function setAttachement($attachment) {
        $this->attachments = $attachment;
    }

    public function setDir($dir) {
        $this->dir = $dir;
    }

    public function getTemplate() {
        return $this->template;
    }

    public function getEmail() {
        $email = $this->prepareEmail();
        return $email;
    }

    public function setAttributes($attributes) {
        $this->attributes = $attributes;
    }

    private function setTemplate() {
        $namespace = $this->namespace;
        $templates = $this->templates;

        if (isset($templates[$namespace])) {
            $this->template = $templates[$namespace];
        }
    }

    private function parseKey($key) {
        return "{" . $key . "}";
    }

    private function fillTemplate() {
        $params = $this->getParams();
        $data = array_merge($params, $this->attributes);
        $template = $this->template;

        foreach($data as $key => $value) {
            $attr = $this->parseKey($key);
            $template = str_replace($attr, $value, $template);
        }

        $this->message = $template;
    }

    private function getParams() {
        $email = array(
            'to' => $this->to,
            'subject' => $this->subject,
            'message' => $this->message,
            'headers' => $this->headers,
            'attachments' => $this->attachments
        );

        return $email;
    }

    private function prepareEmail() {
        if (isset($this->template)) {
            $this->fillTemplate();
        }

        $email = array_values($this->getParams());

        return $email;
    }

    private function getFileNamespace($filename) {
        $parts = explode('-', $filename);
        $namespace = array_shift($parts);

        return $namespace;
    }

    private function load_email_templates() {
        $templates = array();
        $baseURL = get_template_directory();
        $baseURL .= $this->dir;
        
        $files = scandir($baseURL);

        if(is_array($files) && count($files) > 0) {
            $files = array_diff($files, array('.', '..'));

            foreach($files as $index => $filename) {
                $urlTofile = "{$baseURL}/{$filename}";
                $namespace = $this->getFileNamespace($filename);
                $content = load_template_part(null, $urlTofile);
                $templates[$namespace] = $content;
            }
        }

        return $templates;
    }
}