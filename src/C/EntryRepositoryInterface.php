<?php
namespace C\BlogData;

interface EntryRepositoryInterface {

    /**
     * @return mixed
     */
    public function lastUpdateDate();

    /**
     * @param $data
     * @return int
     */
    public function insert($data);

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id);

    /**
     * @param int $page
     * @param int $by
     * @return mixed
     */
    public function mostRecent($page=0, $by=20);

    /**
     * @return int
     */
    public function countAll();
}
