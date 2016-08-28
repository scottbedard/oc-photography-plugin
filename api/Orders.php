<?php namespace Bedard\Photography\Api;

use Bedard\Photography\Repositories\OrderRepository;
use Illuminate\Routing\Controller;

class Orders extends Controller
{
    /**
     * Attach a photo to an order.
     *
     * @param  \Bedard\Photography\Repositories\OrderRepository $repository
     * @param  int                                          $photoId
     * @return \Bedard\Photography\Models\Order
     */
    public function attach(OrderRepository $repository, $photoId)
    {
        return $repository->attachPhoto($photoId);
    }

    /**
     * Fetch the current order information.
     *
     * @return \Bedard\Photography\Models\Order
     */
    public function current(OrderRepository $repository)
    {
        return $repository->currentOrder();
    }

    /**
     * Detach a photo from the order.
     *
     * @param  \Bedard\Photography\Repositories\OrderRepository $repository
     * @param  int                                              $photoId
     * @return \Bedard\Photography\Models\Order
     */
    public function detach(OrderRepository $repository, $photoId)
    {
        return $repository->detachPhoto($photoId);
    }

    /**
     * Process an order
     *
     * @param  \Bedard\Photography\Repositories\OrderRepository $repository
     */
    public function process(OrderRepository $repository) {
        $data = input();

        return $repository->process($data);
    }
}
