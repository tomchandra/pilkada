<?php

declare(strict_types=1);

/**
 * This file is part of Shield OAuth.
 *
 * (c) Datamweb <pooya_parsa_dadashi@yahoo.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use Datamweb\ShieldOAuth\Config\ShieldOAuthConfig as OAuthConfig;

class ShieldOAuthConfig extends OAuthConfig
{
    public array $oauthConfigs = [
        'github' => [
            'client_id'     => 'Get it from GitHub',
            'client_secret' => 'Get it from GitHub',

            'allow_login' => true,
        ],
        'google' => [
            'client_id'     => '338315302980-9cjg6n7btpuq6mu3fge7l7757u62j4ps.apps.googleusercontent.com',
            'client_secret' => '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',

            'allow_login' => true,
        ],
        // 'yahoo' => [
        //     'client_id'     => 'Get it from Yahoo',
        //     'client_secret' => 'Get it from Yahoo',

        //     'allow_login' => true,
        // ],
    ];

    /*
    * If you use different names for the columns in the users table, use the following settings.

    * Data of Table "users":
    * +----+----------+--------+...+------------+-----------+--------+
    * | id | username | status |...| first_name | last_name | avatar |
    * +----+----------+--------+...+------------+-----------+--------+
    * In fact, you set in which column the information received from the services should be recorded.
    * For example, the first name received from OAuth should be recorded in column 'first_name' of the 'users' table shield.
    *
    * NOTE :
    *       This is suitable for those who have already installed the shield and created their own columns.
    *       In this case, there is no need to execute `php spark migrate -n Datamweb\ShieldOAuth`.
    *       Just set the following values with your table columns.
    */
    public array $usersColumnsName = [
        'first_name' => 'first_name',
        'last_name'  => 'last_name',
        'avatar'     => 'avatar',
    ];

    /*
    * If the user is already registered, by default when trying to login, he/she information will be synchronized.
    * if you want to cancel it, set false.
    */
    public bool $syncingUserInfo = false;

    /*
    * When the user login with his profile, the OAuth server directs him to the following path.
    * So change this value only when you need to make an order.
    * By default it returns to the following path:
    * http:\\localhost:8080\oauth\call-back
    */
    public string $call_back_route = 'call-back';
}
