<?php
/**
 * Created by PhpStorm.
 * User: Niko
 * Date: 16.04.2018
 * Time: 13:48
 */

namespace Reddit;


class User {
    private $id;

    /**
     * User constructor.
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function get_id() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function set_id($id) {
        $this->id = $id;
    }

}