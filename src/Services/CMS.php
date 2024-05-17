<?php

namespace App\Services;

use App\Repository\CmsRepository;

class CMS
{
public function getFirstCMS(){
return  $this->cmsRepository->find(1);
}
public function __construct(CmsRepository $cmsRepository){
    $this->cmsRepository = $cmsRepository;
}
}