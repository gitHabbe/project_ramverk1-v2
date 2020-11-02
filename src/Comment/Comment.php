<?php

namespace Hab\Comment;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comment";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $thread_id;
    public $user_id;
    public $name;
    public $points;
    public $reply_num;
    public $created_at;
    public $deleted_at;
    
    private $join;
    /**
     * Build the inner join part.
     *
     * @param string $table     name of table.
     * @param string $condition to join.
     *
     * @return $this
     */
    public function join($table, $condition)
    {

        return $this->createJoin($table, $condition, 'INNER');
    }

    /**
     * Create a inner or outer join.
     *
     * @param string $table     name of table.
     * @param string $condition to join.
     * @param string $type      what type of join to create.
     *
     * @return void
     */
    private function createJoin($table, $condition, $type)
    {
        $this->join .= $type
            . " JOIN " . $table
            . "\n\tON " . $condition . "\n";

        return $this;
    }
        /**
     * Find and return all matching the search criteria.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id IN [?, ?]`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed $value to use in where statement.
     * @param string $table to use in join  statement.
     * @param string $condition to use in join statement.
     *
     * @return array of object of this class
     */
    public function findAllWhereJoin($where, $value, $table, $condition)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
            ->select()
            ->from($this->tableName)
            ->join($table, $condition)
            ->where($where)
            ->execute($params)
            ->fetchAllClass(get_class($this));
    }
}
