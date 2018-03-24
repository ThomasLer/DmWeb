<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 21/02/2018
 * Time: 15:57
 */
class AccountStorageStub implements AccountStorage
{

    public $comptes;

    /**
     * AccountStorageStub constructor.
     * @param $comptes
     */
    public function __construct()
    {
        $this->comptes = array(
            new Account(
                'Toto Dupont',
                'toto',
                '$2y$10$vecze/V//nVxqjpk2VqMOuk46PoPs/ol.xdB4.0OTtj1Z.ee0W4a.',
                'admin'
            ),
            new Account(
                'Jean-Michel Testeur',
                'testeur',
                '$2y$10$Lj0O5fP9xARQvYuo5/dd7.PLAVm9mPo5zwPEohMogU3XwIGN6ZY2C',
                'user'
            ),
            new Account(
                'Martine Dubois',
                'martine',
                '$2y$10$yZ6Wvlp1ylaRK6IwjY0CzuJ.eSQJyao/iMWbHT1SMDKkJ6WEBCnr6',
                'user'
            ),
            new Account(
                'Raymond Martin',
                'raymond',
                '$2y$10$X1HrGzMVPYiOeV6UibjGnuDd/MoGnm0.hwhiwWDmyzjjHlfZpsOlm',
                'user'
            ),
        );
    }

    function checkAuth($login, $password)
    {
        foreach ($this->comptes as $elemCompte) {

            if ($elemCompte->getLogin() == $login && password_verify($password, $elemCompte->getPassword())) {
                $_SESSION['user'] = $elemCompte;
                return true;
            }
        }

        return false;
    }
}