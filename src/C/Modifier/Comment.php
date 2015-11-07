<?php
namespace C\BlogData\Modifier;

use \C\Stream\StreamDate;
use \C\Stream\StreamText;
use \C\Stream\StreamObject;
use \C\Stream\StreamObjectTransform;

/**
 * Class Comment
 * provides stream to forge
 * Comment entities
 *
 * @package C\BlogData\Modifier
 */
class Comment{
    /**
     * return a stream object
     * to transform any pushed $comment entity
     *
     * @param int $range_start
     * @return StreamObjectTransform
     */
    public function transform ($range_start=0) {

        $dateGenerator = new StreamDate();
        $textGenerator = new StreamText();
        $object = new StreamObject();

        return StreamObjectTransform::through()
            ->pipe($object->incProp('id', $range_start))
            ->pipe($object->setProp('blog_entry_id', $range_start))
            ->pipe($dateGenerator->generate('created_at'))
            ->pipe($dateGenerator->modify('created_at', function ($chunk, $prop) use($range_start, $dateGenerator){
                return $dateGenerator->sub($prop, "{$range_start} days + 5*{$range_start}+{$chunk->id} minutes");
            }))
            ->pipe($dateGenerator->generate('updated_at'))
            ->pipe($dateGenerator->modify('updated_at', function ($chunk, $prop) use($range_start, $dateGenerator){
                return $dateGenerator->sub($prop, "{$range_start} days + 5*{$range_start}+{$chunk->id} minutes");
            }))
            ->pipe($textGenerator->enum('author', $textGenerator->nicknames))
            ->pipe($textGenerator->enum('status', ['VISIBLE', 'HIDDEN']))
            ->pipe($textGenerator->sentences('content', rand(1, 3)))
            ;
    }

}
