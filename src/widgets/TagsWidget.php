<?php
namespace jakharbek\tags\widgets;

use Yii;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use jakharbek\categories\models\Categories;
use jakharbek\langs\components\Lang;
use yii\web\JsExpression;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;

/**
 * Class TagsWidget
 * @package jakharbek\tags\widgets
 * Этот виджет нужно вставлять туда где нужно вывести и пременить теги
 *
 */

class TagsWidget extends Widget
{
    /**
     * @var ActiveRecord model_db
     * Ваша модель базы данных записи
     */
    public $model_db;
    /**
     * @var string разделитель данных
     */
    public $delimitr = ",";
    /**
     * @var string имя формачки который будет возврашено
     *  ```html
     * <input name="" />
     * ```
     */
    public $nameform = "tagsform";

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $tags = $this->model_db->tagsFormat($this->delimitr);

        echo SelectizeTextInput::widget([
            'name' => $this->nameform,
            'value' => $tags,
            'clientOptions' => [
                'delimitr' => $this->delimitr,
                'persist' => 'false',
                'create' => new JsExpression('function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }'),
            ],
        ]);
    }
}