<?php

namespace jakharbek\tags\models;

use Yii;
use \jakharbek\tags\models\Tags;
/**
 * This is the ActiveQuery class for [[Tags]].
 *
 * @see Tags
 */
class TagsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Tags[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tags|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $tag
     * @return mixed
     */
    public function tag($tag = null)
    {
        return $this->andWhere(['tag' => $tag]);
    }

    /**
     * @param array $tags
     * @return bool
     * @method Return tags models if tags not founded tag will be created
     */
    public function tags($tags = [],$create_tag = true){
        if(!is_array($tags)){return false;}
        if(count($tags) == 0){return false;}
        $tags_founded_array =  $this->select('tag')->andWhere(['in', 'tag', $tags])->asArray()->all();
        if($this->select('tag')->andWhere(['in', 'tag', $tags])->count() == 0) {
            $tags_diff = $tags;
        }else{
            foreach ($tags_founded_array as $tags_founded_element):
                $tags_founded[] = $tags_founded_element['tag'];
            endforeach;
            $tags_diff = array_diff($tags,$tags_founded);
        }

        if(!count($tags_diff)){
            return Tags::find()->where(['in', 'tag', $tags]);
        }

        foreach ($tags_diff as $tag_diff){
            $tag = new Tags();
            $tag->tag = $tag_diff;
            $tag->save();
        }

        return $this->tags($tags,$create_tag);
    }

}
