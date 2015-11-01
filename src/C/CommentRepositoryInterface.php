<?php
namespace C\BlogData;

interface CommentRepositoryInterface{

    /**
     * @return mixed
     */
    public function lastUpdateDate();

    /**
     * @param $id
     * @return mixed
     */
    public function lastUpdatedByEntryId($id);

    /**
     * @param $data
     * @return int
     */
    public function insert($data);

    /**
     * @param $id
     * @param int $from
     * @param int $length
     * @return mixed
     */
    public function byEntryId($id, $from=0, $length=5);

    /**
     * @param array $excludesEntries
     * @param int $page
     * @param int $by
     * @return mixed
     */
    public function mostRecent($excludesEntries=[], $page=0, $by=20);
}
