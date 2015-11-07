<?php

use \C\Fixture\Generator;
use \C\Stream\StreamObject;

use \C\BlogData\Entity\Entry as EntryEntity;
use \C\BlogData\Entity\Comment as CommentEntity;

use \C\BlogData\Modifier\Entry as EntryModifier;
use \C\BlogData\Modifier\Comment as CommentModifier;

$object      = new StreamObject();
$entry      = new EntryModifier();
$comment    = new CommentModifier();

/**
 * generate a hundred entries
 * each entry has 2 comments
 *
 * their status (VISIBLE, HIDDEN)
 * is random.
 *
 */
return Generator::generate( new EntryEntity(),
    $entry->transform()
        ->pipe( $object->modify('comments',
            function ($chunk) use($comment) {
                return Generator::generate( new CommentEntity(),
                    $comment->transform($chunk->id), 2 );
            })
        )
    , 100);