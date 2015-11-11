<?php
namespace C\BlogData\Eloquent;

use C\BlogData\EntryRepositoryInterface;
use C\Misc\Utils;
use Illuminate\Database\Query\Builder;

class EntryRepository
    extends \C\Eloquent\Repository implements EntryRepositoryInterface {

    /**
     * @return Builder
     */
    public function all() {
        return $this->capsule->getConnection()
            ->table('blog_entry')
            ;
    }

    /**
     * @return Builder
     */
    public function lastUpdateDate() {
        return $this->all()
            ->take(1)
            ->orderBy('updated_at','DESC')
            ->select(['updated_at'])
            ;
    }

    /**
     * @param array $data
     * @return int
     */
    public function insert($data) {
        return $this->all()
            ->insertGetId(Utils::objectToArray($data));
    }

    /**
     * @param $id
     * @return Builder
     */
    public function byId($id) {
        return $this->all()
            ->where('id', '=', $id)
            ->take(1);
    }

    /**
     * @param int $page
     * @param int $by
     * @return Builder
     */
    public function mostRecent($page=0, $by=5) {
        return $this->all()
            ->offset($page*$by)
            ->take($by)
            ->orderBy('updated_at', 'DESC');
    }

    /**
     * @return int
     */
    public function countAll() {
        return $this->all()
            ->count('id');
    }
}
