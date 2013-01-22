<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsernameRule
 *
 * @author georgeee
 */
class UsernameRule extends CBaseUrlRule {

    public $connectionID = 'db';
    public $prefix = 'users';

    public function createUrl($manager, $route, $params, $ampersand) {
        $isAccounts = $isHistory = false;
        if ($route == LilyModule::route('user/view') 
                || ($isAccounts = ($route == LilyModule::route('account/list'))) 
                || ($isHistory = ($route == 'site/mergeHistory')) ) {
            if (!isset($params['uid']))
                return false;
            $profile = Profile::model()->find('uid=:uid', array(':uid' => $params['uid']));
            if (!isset($profile))
                return false;
            return "{$this->prefix}/{$profile->username}" . ($isAccounts ? '/accounts' : ($isHistory?'/history':''));
        }
        return false; // this rule does not apply
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        $matches = array();
        //Profile::USERNAME_PATTERN
        if (preg_match('~^' . preg_quote($this->prefix, '~') . '/([0-9A-Za-z\\-_.]{5,20})(?:/(?:(accounts)|(history)))?$~', $pathInfo, $matches)) {
            $username = $matches[1];
            $profile = Profile::model()->find('username=:un', array(':un' => $username));
            if (!isset($profile))
                return false;
            $_GET['uid'] = $profile->uid;
            return empty($matches[2]) ?(empty($matches[3]) ?LilyModule::route('user/view'):'site/mergeHistory') : LilyModule::route('account/list');
        }
        return false; // this rule does not apply
    }

}
