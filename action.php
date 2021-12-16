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

        $tokenExtras = $oauth->getStorage()->retrieveAccessToken($oauth->service())->getExtraParams();
        $idToken = $tokenExtras['id_token'] ?? '';

        $decodedObj = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $idToken)[1]))));
        $result = (array)$decodedObj;

        $data['user'] = $result['preferred_username'] ?? $result['cognito:username'];
        $data['name'] = $result['name'] ?? $data['user'];
        $data['mail'] = $result['email'];

        if (isset($result['cognito:groups'])) {
            $data['grps'] = $result['cognito:groups'];
        }

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
