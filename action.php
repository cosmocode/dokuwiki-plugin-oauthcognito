<?php

use dokuwiki\plugin\oauth\Adapter;
use dokuwiki\plugin\oauthcognito\Cognito;

/**
 * OAuth Cognito authentication
 */
class action_plugin_oauthcognito extends Adapter
{

    /** @inheritdoc */
    public function registerServiceClass()
    {
        return Cognito::class;
    }

    /** * @inheritDoc */
    public function getUser()
    {
        $oauth = $this->getOAuthService();
        $data = array();

        $url = $this->getConf('baseurl') . '/oauth2/userInfo';

        $raw = $oauth->request($url);
        $result = json_decode($raw, true);

        $data['user'] = $result['preferred_username'] ?? $result['username'];
        $data['name'] = $result['name'] ?? $data['user'];
        $data['mail'] = $result['email'];

        return $data;
    }

    /** @inheritDoc */
    public function getLabel()
    {
        return 'Cognito';
    }

    /** @inheritDoc */
    public function getColor()
    {
        return '#404041';
    }

}
