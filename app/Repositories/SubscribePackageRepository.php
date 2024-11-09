<?php

namespace App\Repositories;

use App\Repositories\Contracts\SubscribePackageRepositoryInterface;
use App\Models\SubscribePackage;

class SubscribePackageRepository implements SubscribePackageRepositoryInterface
{
    public function getAllSubscribePackages()
    {
        return SubscribePackage::latest()->get();
    }

    public function find($id)
    {
        return SubscribePackage::find($id);
    }

    public function getPrice($subscribePackageId)
    {
        $subscribePackage = $this->find($subscribePackageId);
        return $subscribePackage ? $subscribePackage->price : 0;
    }
}
