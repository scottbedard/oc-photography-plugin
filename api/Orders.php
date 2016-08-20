<?php namespace Bedard\Photography\Api;

use Bedard\Photography\Repositories\OrderRepository;
use Illuminate\Routing\Controller;

class Orders extends Controller
{

    /**
     * Attach a photo to an order
     *
     * @paran  \Bedard\Photography\Repositories\OrderRepository $repository
     * @param  integer                                          $photoId
     * @return \Bedard\Photography\Models\Order
     */
    public function attach(OrderRepository $repository, $photoId)
    {
        return $repository->attachPhoto($photoId);
    }
}
