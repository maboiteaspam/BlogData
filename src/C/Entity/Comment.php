<?php
namespace C\BlogData\Entity;

class Comment{

    public $id;
    public $blog_entry_id;
    public $created_at;
    public $updated_at;
    public $author;
    public $content;
    public $status;
}
