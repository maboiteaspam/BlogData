<?php
namespace C\BlogData\Eloquent;

use C\BlogData\CommentRepositoryInterface;
use C\Misc\Utils;
use C\Repository\EloquentRepository;
use Illuminate\Database\Query\Builder;

class CommentRepository extends EloquentRepository implements CommentRepositoryInterface {

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
            ->select(['updated_at']);
    }

    /**
     * @param $id
     * @return Builder
     */
    public function lastUpdatedByEntryId($id) {
        return $this
            ->byEntryId($id)
            ->select(['updated_at']);
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
     * @param int $from
     * @param int $length
     * @return Builder
     */
    public function byEntryId($id, $from=0, $length=5) {
        return $this->all()
            ->where('blog_entry_id', '=', $id)
            ->offset($from)
            ->take($length)
            ->orderBy('updated_at','DESC')
            ;
    }

    /**
     * @param array $excludesEntries
     * @param int $page
     * @param int $by
     * @return Builder
     */
    public function mostRecent($excludesEntries=[], $page=0, $by=5) {
        return $this->all()
            ->whereNotIn('blog_entry_id', $excludesEntries)
            ->offset($page*$by)
            ->take($by)
            ->orderBy('updated_at', 'DESC')
            ;
    }
}
