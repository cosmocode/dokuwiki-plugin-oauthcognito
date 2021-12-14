<?php

namespace dokuwiki\plugin\oauthcognito;

use dokuwiki\plugin\oauth\Service\AbstractOAuth2Base;
use OAuth\Common\Http\Uri\Uri;

/**
 * Custom Service for Amazon Cognito
 */
class Cognito extends AbstractOAuth2Base
{

    /** @inheritdoc */
    public function getAuthorizationEndpoint()
    {
        $plugin = plugin_load('action', 'oauthcognito');
        return new Uri($plugin->getConf('baseurl') . '/oauth2/authorize');
    }

    /** @inheritdoc */
    public function getAccessTokenEndpoint()
    {
        $plugin = plugin_load('action', 'oauthcognito');
        return new Uri($plugin->getConf('baseurl') . '/oauth2/token');
    }

    /**
     * @inheritdoc
     */
    protected function getAuthorizationMethod()
    {
        return static::AUTHORIZATION_METHOD_QUERY_STRING;
    }
}
