<?php
/*!
* Hybridauth
* https://hybridauth.github.io | https://github.com/hybridauth/hybridauth
*  (c) 2017 Hybridauth authors | https://hybridauth.github.io/license.html
*/

namespace Hybridauth\Provider;

use Hybridauth\Adapter\OAuth2;
use Hybridauth\Exception\UnexpectedApiResponseException;
use Hybridauth\Data;
use Hybridauth\User;

/**
 * Blizzard Battle.net OAuth2 provider adapter.
 */
class Blizzard extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    public $scope = '';

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://us.api.battle.net/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://us.battle.net/oauth/authorize';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://us.battle.net/oauth/token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://dev.battle.net/docs/read/oauth';

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('account/user');

        $data = new Data\Collection($response);

        if (!$data->exists('id')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier  = $data->get('id');
        $userProfile->displayName = $data->get('battletag') ?: $data->get('login');

        return $userProfile;
    }
}
