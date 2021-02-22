<?php

use System\Controller\Controller;

class IndexController extends Controller
{
    public function index(): void
    {
        //$this->load->template('message', ['message' => 'siemka']);
        /*
        var_dump($this->db
            ->select('id')
            ->from('numbers')
            ->where([
                'id' => 1
            ])
            ->getQuery());

        $this->db->clearQuery();

        var_dump($this->db
            ->insert([
                'id' => 1,
                'number' => 55
            ])
            ->into('numbers')
            ->getQuery());

        $this->db->clearQuery();

        var_dump($this->db
            ->update('numbers')
            ->set(['number' => 5])
            ->where(['id' => 3])
            ->getQuery());

        $this->db->clearQuery();

        var_dump($this->db->delete()->from('numbers')->where(['id' => 1])->getQuery());exit;
        */

    }
}