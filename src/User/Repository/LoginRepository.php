<?php

/**
 * Description of LoginRepository
 *
 * @author broklyn
 */

namespace User\Repository;

class LoginRepository
{
    public static function getLoginUser(\Jazz\Application $app, $userName, $password)
    {
        $sql = "select user.*, role.*, role_permission.* from user ".
               "INNER JOIN role_permission AS rp ON rp. ".
               "where username = :username";
        
        $query = $app['db']->prepare($sql);
        $query->bindParam('username', $userName, \PDO::PARAM_STR);
        $user = $query->fetch(\PDO::FETCH_ASSOC);
        
        if ($userName === $user['username'] && $password === $user['password']) {
           return $user; 
        }
        
        return false;
    }
    
}
