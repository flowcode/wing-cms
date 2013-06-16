<?php

namespace flowcode\cms\domain;

/**
 *
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
interface IPage {

    public function getPermalink();

    public function getTitle();

    public function getMetaDescription();
}

?>
