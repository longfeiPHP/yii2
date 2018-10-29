<?php
namespace app\modules\backend\rbac;


use Yii;
use yii\rbac\Rule;


class CommonRule extends Rule
{
    public $name = 'CommonRule';
    public function execute($user, $item, $params)
    {
        // 这里先设置为false,逻辑上后面再完善
        return true;
    }
}