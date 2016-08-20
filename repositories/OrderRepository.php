<?php namespace Bedard\Photography\Repositories;

use Bedard\Photography\Models\Order;
use Bedard\Photography\Models\Photo;
use Session;

class OrderRepository
{

    /**
     * @var string
     */
    private $sessionKey = 'bedard_photography_order_session';

    /**
     * Add a photo to a new or existing order
     *
     * @param  array    $data
     * @return
     */
    public function attachPhoto($photoId)
    {
        // Fetch the photo and order
        $photo = Photo::findOrFail($photoId);
        $order = $this->getOrder() ?: $this->createOrder();

        // Attach the photo to the order if we don't already have it
        $order->load(['photos' => function($photos) {
            return $photos->select('system_files.id');
        }]);

        $orderPhotoIds = $order->photos->lists('id');

        if (!in_array($photoId, $orderPhotoIds)) {
            $order->photos()->attach($photo);
            $order->save();
        }

        return $order;
    }

    /**
     * Create a new order
     *
     * @return Bedard\Photography\Models\Order
     */
    protected function createOrder()
    {
        $order = Order::create();

        Session::put($this->sessionKey, [
            'id' => $order->id,
            'token' => $order->session_token,
        ]);

        return $order;
    }

    /**
     * Fetch the users order
     *
     * @return \Bedard\Photography\Models\Order | null
     */
    protected function getOrder()
    {
        if ($session = Session::get($this->sessionKey)) {
            return Order::findBySession($session);
        }

        return null;
    }
}
