<?php
class HomeController
{
    public function index()
    {
        $repo  = new UserRepository();
        $users = $repo->getTopUsersByFollowers(5);
        require "view/home/index.php";
    }

}
