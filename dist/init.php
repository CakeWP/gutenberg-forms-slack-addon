<?php

//registering addon
require_once plugin_dir_path(__FILE__) . 'api.php';


add_filter('gutenberg_forms_integrations', function ($integrations) {

    $arguments = array(
        'title' => 'Slack',
        'is_pro'  => true,
        'type'  => 'autoResponder',
        'guide' => '',
        'description' => 'Slack Addon for Gutenberg Forms lets you connect Slack with your form. You can send leads to any of your lists in Slack when a user submits the form.',
        'banner' => 'https://i.pcmag.com/imagery/reviews/07td46ju7p6lLVb0QGwc5VF-6..v_1569479844.jpg'
        'fields' => array(
            'webhook_url' =>  array(
                'label' => 'Webhook URL',
                'default' => '',
                'type' => 'string',
            )
        ),
        'query_fields' => array(),
        'api_fields' => array(
            'EMAIL' => array(
                'label' => 'Email'
            ),
            'FNAME' => array(
                'label' => 'First Name'
            ),
            'LNAME' => array(
                'label' => 'Last Name'
            ),
            'PHONE' => array(
                'label' => 'Phone'
            ),
            'ADDRESS_1' => array(
                'label' => 'Address 1'
            ),
            'STATE' => array(
                'label' => 'State'
            ),
            'ZIP' => array(
                'label' => 'Zip Code'
            ),
            'COUNTRY' => array(
                'label' => 'Country'
            ),
            'CITY'  => array(
                'label' => 'City'
            )
        )
    );

    $integrations['mailchimp'] = $arguments;

    return $integrations;
});


add_action('gutenberg_forms_submission__mailchimp', function ($entry) {

    $mailChimp = new cwp_gf_addon_MailChimp();

    $mailChimp->post($entry);
});
