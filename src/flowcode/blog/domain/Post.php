<?php

namespace flowcode\blog\domain;

use flowcode\wing\mvc\Config;
use flowcode\wing\mvc\Entity;

/**
 * Description of Noticia
 *
 * @author juanma
 */
class Post extends Entity {

    private $permalink;
    private $title;
    private $body;
    private $intro;
    private $type;
    private $status;
    private $imageSlot;
    private $imageSlotTop;
    private $imageSlotLeft;
    private $imageSlotSize;
    private $date;
    private $tags = null;
    public static $draft = 0;
    public static $published = 1;

    public function __construct() {
        parent::__construct();
        $this->imageSlotLeft = 0;
        $this->imageSlotTop = 0;
        $this->imageSlotSize = 100;
    }

    public function getPermalink() {
        return $this->permalink;
    }

    public function setPermalink($permalink) {
        $this->permalink = $permalink;
    }

    public function setImageSlot($url) {
        $this->imageSlot = $url;
    }

    public function getImageSlot() {
        return $this->imageSlot;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getFormatedDate() {
        return date("d/m/Y H:i", strtotime($this->date));
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getImageSlotUri() {
        $toReturn = Config::get('images', 'default');

        if (file_exists($_SERVER{'DOCUMENT_ROOT'} . $this->imageSlot) && $this->imageSlot != "") {
            $toReturn = $this->imageSlot;
        }
        return $toReturn;
    }

    public function getDate() {
        $returnFecha = date("Y-m-d H:i:s");
        if ($this->date != "" && $this->date != null) {
            $returnFecha = $this->date;
        }
        return $returnFecha;
    }

    public function getImageSlotTop() {
        return $this->imageSlotTop;
    }

    public function setImageSlotTop($imageSlotTop) {
        $this->imageSlotTop = $imageSlotTop;
    }

    public function getImageSlotLeft() {
        return $this->imageSlotLeft;
    }

    public function setImageSlotLeft($imageSlotLeft) {
        $this->imageSlotLeft = $imageSlotLeft;
    }

    public function getImageSlotSize() {
        return $this->imageSlotSize;
    }

    public function setImageSlotSize($imageSlotSize) {
        $this->imageSlotSize = $imageSlotSize;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getIntro() {
        return $this->intro;
    }

    public function setIntro($intro) {
        $this->intro = $intro;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function __toString() {
        return $this->name;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }

}

?>
