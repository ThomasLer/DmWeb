<?php
interface JVDStorage{
    public function read($id);
    public function readAll();
    public function create(JVD $a);
}