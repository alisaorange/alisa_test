<?php

namespace app\backend\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class SlugBehavior extends Behavior
{
    public $in_attribute = 'title';
    public $out_attribute = 'slug';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'getSlug'
        ];
    }

    public function getSlug( $event )
    {
        if ( empty( $this->owner->{$this->out_attribute} ) ) {
            $this->owner->{$this->out_attribute} = $this->generateSlug( $this->owner->{$this->in_attribute} );
        } else {
            $this->owner->{$this->out_attribute} = $this->generateSlug( $this->owner->{$this->out_attribute} );
        }
    }

    private function generateSlug( $slug )
    {
        $slug = $this->transliterate( $slug );
        if ( $this->checkUniqueSlug( $slug ) ) {
            return $slug;
        } else {
            for ( $suffix = 1; !$this->checkUniqueSlug( $new_slug = $slug . '-' . $suffix ); $suffix++ ) {}
            return $new_slug;
        }
    }

    private function checkUniqueSlug( $slug )
    {
        $pk = $this->owner->primaryKey();
        $pk = $pk[0];

        $condition = $this->out_attribute . ' = :out_attribute';
        $params = [ ':out_attribute' => $slug ];
        if ( !$this->owner->isNewRecord ) {
            $condition .= ' and ' . $pk . ' != :pk';
            $params[':pk'] = $this->owner->{$pk};
        }

        return !$this->owner->find()
            ->where( $condition, $params )
            ->one();
    }
        
    public static function transliterate($string, $length = 140) {
        $translit = array(
            'а' => 'a',  'б' => 'b',  'в' => 'v',
            'г' => 'g',  'д' => 'd',  'е' => 'e',
            'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i',  'й' => 'i',  'к' => 'k',
            'л' => 'l',  'м' => 'm',  'н' => 'n',
            'о' => 'o',  'п' => 'p',  'р' => 'r',
            'с' => 's',  'т' => 't',  'у' => 'u',
            'ф' => 'f',  'х' => 'h',  'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '',   'ы' => 'y',  'ь' => '',
            'э' => 'e',  'ю' => 'yu', 'я' => 'ya',
            ' ' => '-',  '–' => ''
        );

                $string = substr($string, 0, $length);
        $string = mb_strtolower($string);

        // cleaup
        $string = preg_replace('/[^a-zа-я0-9–\-\s]/u', '', $string);
        // trasnliterate
        $string = strtr($string, $translit);
        // replace space symbols to '-'
        $string = preg_replace('/\s/u', '-', $string);
        // collapse several '-' symbols to one
        $string = preg_replace('/\-{2,}/u', '-', $string);
        // remove '-' symbols from beggining and ending
        $string = preg_replace( '/(^-)|(-$)/us', '', $string);
        
        return $string;
    }

}