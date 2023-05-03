<?php

namespace App\Library;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

interface ORMInterface
{
    public function add();
    public function update();
    public function remove();
    public function removeMany();
    
    
}

trait ORMtrait
{
    protected ServiceEntityRepository $repo;

    public function __construct(ServiceEntityRepository $repo)
    {
        $this->repo = $repo;
    }

    public function add()
    {

    }

    public function update()
    {

    }
    
    public function remove()
    {

    }

    public function removeMany()
    {

    }

    
}


class Library implements ORMInterface
{

use ORMtrait;

}
