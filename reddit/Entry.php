<?php
/**
 * Created by PhpStorm.
 * User: Niko
 * Date: 16.04.2018
 * Time: 13:39
 */

namespace Reddit;


class Entry {

    private $title, $image, $posted_on, $author, $comments, $sub, $url;//the $comments will store number of comments

    /**
     * Entry constructor.
     * @param $data array of data
     */
    public function __construct($data) {
        $this->title = $data['title'];
        $this->image = $data['image'];
        $this->posted_on = $data['posted_on'];
        $this->author = $data['author'];
        $this->comments = $data['comments'];
        $this->sub = $data['sub'];
        $this->url = $data['url'];
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getPostedOn() {
        return $this->posted_on;
    }

    /**
     * @return mixed
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function getSub() {
        return $this->sub;
    }

}