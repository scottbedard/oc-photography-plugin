<?php namespace Bedard\Photography\Repositories;

use Bedard\Photography\Models\Order;
use Bedard\Photography\Models\Photo;
use Session;
use System\Models\File;

class OrderRepository
{
    /**
     * @var string
     */
    private $sessionKey = 'bedard_photography_order_session';

    /**
     * Add a photo to a new or existing order.
     *
     * @param  array    $data
     * @return
     */
    public function attachPhoto($photoId)
    {
        // Fetch the photo and order
        $photo = Photo::findOrFail($photoId);
        $order = $this->getOrder(true);

        // Attach the photo to the order if we don't already have it
        if (! $order->photos()->where('system_files.id', $photo->id)->exists()) {
            $order->photos()->attach($photo);
            $order->save();
        }

        return $this->load($order);
    }

    /**
     * Return the current order.
     *
     * @return \Bedard\Photography\Models\Order
     */
    public function currentOrder()
    {
        $order = $this->getOrder();

        return $this->load($order);
    }

    /**
     * Detach a photo from the order.
     *
     * @param   int   $photoId
     */
    public function detachPhoto($photoId)
    {
        $photo = Photo::findOrFail($photoId);
        $order = $this->getOrder(true);

        // Detach the photo
        $order->photos()->detach($photo);
        $order->save();

        // Load the order information
        return $this->load($order);
    }

    /**
     * Fetch an order and it's photos for download.
     *
     * @param  string                           $token  The unique token to identify the order
     * @return \Bedard\Photography\Models\Order
     */
    public function download($token)
    {
        $order = Order::whereDownloadToken($token)
            ->with('photos')
            ->firstOrFail();

        $order->logStatus('downloaded');

        return $order;
    }

    /**
     * Download a photo
     *
     * @param  integer $id
     * @param  string  $diskName
     * @return array
     */
    public function file($id, $diskName)
    {
        $file = File::whereDiskName($diskName)->findOrFail($id);

        return [
            'name' => $file->file_name,
            'path' => public_path() . $file->getPath(),
        ];
    }

    /**
     * Process an order.
     *
     * @param  array    $data
     */
    public function process($data)
    {
        $order = $this->getOrder();
        $order->name = $data['name'];
        $order->email = $data['email'];
        $order->stripe_token = $data['stripe_token'];
        $order->status = 'processing';
        $order->save();
        $order->queueStripePayment();
    }

    /**
     * Create a new order.
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
     * Fetch the users order.
     *
     * @return \Bedard\Photography\Models\Order | null
     */
    protected function getOrder($create = false)
    {
        // Check if we have a session going
        $session = Session::get($this->sessionKey);

        if ($session) {
            // If we do, look for the order
            $order = Order::notComplete()->findBySession($session);
            if ($order->exists()) {
                return $order;
            }
        }

        // If either of the above failed, return a new order
        return $create ? $this->createOrder() : new Order;
    }

    /**
     * Load order information.
     *
     * @param  \Bedard\Photography\Models\Order $order
     * @return \Bedard\Photography\Models\Order
     */
    protected function load(Order $order)
    {
        $order->load(['photos' => function ($photos) {
            return $photos
                ->select(['system_files.id', 'attachment_id'])
                ->with(['gallery', 'watermarkedPhotos']);
        }]);

        return $order;
    }
}
