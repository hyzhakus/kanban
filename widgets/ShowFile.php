<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\FileHelper;

class ShowFile extends \yii\bootstrap4\Widget
{

    public $user_id;

    public function run() {
        $type = 'avatar';
        $filename = md5($this->user_id) . '.png';
        $filepath = Yii::getAlias( '@app/web/uploads/') . $filename;

        if(!file_exists( $filepath )) {
            $filename = '/uploads/avatar.png';
        } else {
            $filename = '/uploads/'. $filename;
        }
        return Html::img( $filename . '?' . time(), ['width'=>50, 'height'=>50, 'class'=>'rounded-circle']) ;
    }

}
