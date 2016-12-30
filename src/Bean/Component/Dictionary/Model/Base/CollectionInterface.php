<?php
/**
 * Created by PhpStorm.
 * User: Binh
 * Date: 12/30/2016
 * Time: 12:04 PM
 */
namespace Bean\Component\Dictionary\Model\Base;

interface CollectionInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param mixed $title
     */
    public function setTitle($title);
}