<?php


class cwp_gf_addon_Slack
{

    # required version of gutenberg forms to run this addon
    const required_gf_version = "2.0.0";

    public function __construct()
    {
        $this->webhook_url = get_option('cwp__slack__webhook_url');
    }

    /**
     * Will post the entry to the given webhook
     * @param array $entry Gutenberg Form Entry
     */

    public function post($entry)
    {

        $form_title = $entry['post_meta']['title'];
        $form_id = $entry['post_meta']['form_id'];
        $admin_url = $entry['post_meta']['admin_url'];
        $form_fields = $entry['fields'];

        $form_entries_url = "$admin_url#/entries/$form_id";


        $json_path = plugin_dir_path(__FILE__) . 'template.json';

        $slack_template = file_get_contents($json_path);

        $slack_decoded_template = json_decode($slack_template, TRUE);
        $template_fields = [];

        $slack_decoded_template['blocks'][0]['text']['text'] = "You have a new form submission: <$form_entries_url|$form_title>";

        foreach ($form_fields as $field_name => $field_value) :


            $template_fields[] = [
                'type' => 'mrkdwn',
                'text' => "*$field_name:*\n$field_value"
            ];


        endforeach;

        $slack_decoded_template['blocks'][1]['fields'] = $template_fields;
        $slack_decoded_template['blocks'][2]['elements'][0]['url'] = $form_entries_url;

        $args = array(
            'body'        => json_encode($slack_decoded_template),
            'timeout'     => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(),
            'cookies'     => array(),
        );

        $response = wp_remote_post($this->webhook_url, $args);
    }
}
