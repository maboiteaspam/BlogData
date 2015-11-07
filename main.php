<?php
require 'vendor/autoload.php';

use \C\Stream\StreamFlow;
use \C\Stream\StreamObject;
use \C\Stream\StreamObjectTransform;
use \C\Fixture\Generator;

use \C\BlogData\Modifier\Entry as EntryModifier;
use \C\BlogData\Modifier\Comment as CommentModifier;
use \C\BlogData\Entity\Entry as EntryEntity;
use \C\BlogData\Entity\Comment as CommentEntity;


$entry      = new EntryModifier();
$comment    = new CommentModifier();
$object     = new StreamObject();

$entries = Generator::generate( new EntryEntity(),
    $entry->transform()
        ->pipe( $object->modify('comments',
            function ($chunk) use($comment) {
                return Generator::generate( new CommentEntity(),
                    $comment->transform($chunk->id), 2 );
            })
        )
    , 20);


//var_dump($entries[0]);
//var_dump($entries[1]->id);
//var_dump($entries[1]->comments[0]->blog_entry_id);
//var_dump($entries[1]->comments[1]->blog_entry_id);
var_dump(count($entries));

StreamObjectTransform::through()
    ->pipe( StreamFlow::duplex(2)
            ->pipe(function($chunk){
                var_dump("duplexed $chunk");
            })
    )
    ->pipe(function($chunk){
        var_dump("not duplexed $chunk");
    })
    ->write('some');

