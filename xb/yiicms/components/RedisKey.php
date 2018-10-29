<?php
/**
 * Created by PhpStorm.
 * User: lifeicheng
 * Date: 2017/12/16
 * Time: 下午5:07
 */

namespace app\components;


class RedisKey
{
    public static $storePrefix = 'ww::s::';
    public static $cachePrefix = 'ww::c::';

    /**
     * 问问医生总人数key
     * @return string
     */
    public static function getSalesKey()
    {
        return static::$storePrefix."sales::total";
    }

    public static function userCodeValueKey($mobile)
    {
        return static::$cachePrefix."login::{$mobile}::code";
    }

    public static function getUserInfoKey($uid)
    {
        return static::$storePrefix."user::$uid";
    }

    public static function sendVerifyCodeTimeBy24hKey($mobile)
    {
        return static::$cachePrefix.$mobile."times";
    }

    public static function effectTimeKey($mobile)
    {
        return static::$cachePrefix.$mobile.'::effect::time';
    }

    public static function levelKey($id)
    {
        return static::$storePrefix.'News::'.$id;
    }

}