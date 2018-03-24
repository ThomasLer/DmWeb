<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 21/02/2018
 * Time: 15:56
 */
interface AccountStorage
{
    function checkAuth($login, $password);
}