<?php
namespace C\BlogData\Entity;

class Entry{

    public $id;
    public $created_at;
    public $updated_at;
    public $title;
    public $author;
    public $img_alt;
    public $content;
    public $status;
    /**
     * @var array C\BlogData\Entity\Comment
     */
    public $comments = [];
}
