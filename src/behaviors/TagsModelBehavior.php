<?php
namespace jakharbek\tags\behaviors;

/**
 *
 * @author Jakhar <javhar_work@mail.ru>
 *
 */

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use \jakharbek\tags\models\Tags;


class TagsModelBehavior extends AttributeBehavior
{
    /**
     * @var string имя атрибута откуда брать информацию из формқ
     */
    public $attribute = "tagsform";
    /**
     * @var string имя разделителя данных
     */
    public $delimitr = ",";

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'saveData',
            ActiveRecord::EVENT_BEFORE_UPDATE  => 'saveData'
        ];
    }

    public function saveData(){
        if(!$this->owner->isNewRecord):
            $this->unlinkData();
        endif;
        $this->linkData();
    }

    private function unlinkData(){
        $tags = $this->owner->tags;
        if(count($tags) == 0){return false;}
        foreach ($tags as $tag):
            $this->owner->unlink('tags',$tag,true);
        endforeach;
    }

    private function linkData(){

        $data = $this->owner->{$this->attribute};
        if(strlen($data) == 0){return false;}
        $data = preg_replace('/\s+/', '', $data);
        $array_tags_str = explode($this->delimitr,$data);

        $tags = Tags::find()->tags($array_tags_str)->all();
        if($tags):
            foreach ($tags as $tag)
            {
                $this->owner->link('tags',$tag);
            }
        endif;
    }

    public function tagsFormat($delimitr = ","){
        $tags = $this->owner->tags;
        if($tags == false){return '';}
        $data = [];
        foreach ($tags as $tag):
            $data[] = $tag['tag'];
        endforeach;
        return implode($delimitr,$data);
    }
}