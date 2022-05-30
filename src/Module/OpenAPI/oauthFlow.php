<?php

/**
 * This file is part of webman-auto-route.
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    十云<author@10yun.com>
 * @copyright 十云<author@10yun.com>
 * @link      https://www.10yun.com/
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace shiyun\annotation\Module\OpenAPI;

/**
 * @link https://swagger.io/specification/#oauth-flow-object 规范文档
 */
class oauthFlow
{
    const authorizationUrl = 'authorizationUrl';
    const tokenUrl         = 'tokenUrl';
    const refreshUrl       = 'refreshUrl';
    const scopes           = 'scopes';
}
