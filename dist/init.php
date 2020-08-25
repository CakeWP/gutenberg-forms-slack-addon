<?php

require_once plugin_dir_path(__FILE__) . 'api.php';

$gf_slack_api = new cwp_gf_addon_Slack();
$supported_version = (float)cwp_gf_addon_Slack::required_gf_version;

add_filter('gutenberg_forms_integrations', function ($integrations) use ($gf_slack_api, $supported_version) {

    $arguments = array(
        'title' => 'Slack',
        'is_pro'  => true,
        'type'  => 'autoResponder',
        'guide' => '',
        'description' => 'Slack Addon for Gutenberg Forms lets you connect Slack with your form. You can send leads to any of your lists in Slack when a user submits the form.',
        'banner' => 'https://p111.p2.n0.cdn.getcloudapp.com/items/E0unoEbq/Image%202020-08-25%20at%204.01.06%20PM.png',
        'fields' => array(
            'webhook_url' =>  array(
                'label'     => 'Webhook URL',
                'default'   => '',
                'hidden'    => false,
                'type'      => 'string',
                'field_type' => 'url'
            )
        ),
        'query_fields' => array(),
        'api_fields' => array(),
        'include_all_fields' => true,
        'include_extra'      => true
    );

    $plugins = get_plugins();
    $gutenberg_forms_init_script = 'gutenberg-forms/plugin.php';
    $gutenberg_form_details = array_key_exists($gutenberg_forms_init_script, $plugins) ? $plugins[$gutenberg_forms_init_script] : [];
    $gutenberg_form_version = array_key_exists('Version', $gutenberg_form_details) ? (float)$gutenberg_form_details['Version'] : null;


    if (!is_null($gutenberg_form_version) and $gutenberg_form_version < $supported_version) {

        $arguments['is_disabled'] = true; // disabling the integration
        $arguments['error'] = array(
            'status'    => 'error',
            'message'   => 'In order to use Gutenberg Forms Slack Addon please update Gutenberg Forms to version 2.0.0 or above.'
        );
    }

    $integrations['slack'] = $arguments;

    return $integrations;
});


add_action('gutenberg_forms_submission__slack', array($gf_slack_api, 'post'));
