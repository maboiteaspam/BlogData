<?php
namespace C\BlogData\Modifier;

use \C\Stream\StreamImgUrl;
use \C\Stream\StreamDate;
use \C\Stream\StreamText;
use \C\Stream\StreamObject;
use \C\Stream\StreamObjectTransform;

/**
 * Class Entry
 * provides stream to forge
 * Entry entities
 *
 * @package C\BlogData\Modifier
 */
class Entry{
    /**
     * return a stream object
     * to transform any pushed $entry entity
     *
     * @param int $range_start
     * @return mixed
     */
    public function transform ($range_start=0) {

        $imgUrlGenerator = new StreamImgUrl();
        $dateGenerator = new StreamDate();
        $textGenerator = new StreamText();
        $object = new StreamObject();

        return StreamObjectTransform::through()
            ->pipe($object->incProp('id', $range_start))
            ->pipe($dateGenerator->generate('created_at'))
            ->pipe($dateGenerator->modify('created_at', function ($chunk, $prop) use($dateGenerator){
                return $dateGenerator->sub($prop, "{$chunk->id} days + 1*{$chunk->id} hours");
            }))
            ->pipe($dateGenerator->generate('updated_at'))
            ->pipe($dateGenerator->modify('updated_at', function ($chunk, $prop) use($dateGenerator){
                return $dateGenerator->sub($prop, "{$chunk->id} days + 1*{$chunk->id} hours");
            }))
            ->pipe($textGenerator->enum('author', $textGenerator->nicknames))
            ->pipe($textGenerator->enum('status', ['VISIBLE', 'HIDDEN']))
            ->pipe($textGenerator->words('title', rand(2, 5)))
            ->pipe($textGenerator->sentences('content', rand(1, 3)))
            ->pipe($imgUrlGenerator->imgUrl('img_alt', rand(1, 3)))
            ;
    }
}
