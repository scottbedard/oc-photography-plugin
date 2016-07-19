<?php namespace Bedard\Photography\Models;

use Bedard\Photography\Classes\ImageEditor;
use Queue;
use System\Models\File;

class Photo extends File
{
    /**
     * @var array Relations
     */
    public $attachMany = [
        'watermarkedPhotos' => 'System\Models\File',
    ];

    /**
     * Construct.
     */
    public function __construct()
    {
        parent::__construct();

        // Events are bound here to avoid collisions with \System\Models\File
        static::extend(function($model) {
            $model->bindEvent('model.afterDelete', function() use ($model) {
                $model->deleteWatermarks();
            });
        });
    }

    /**
     * Create watermarked photos
     *
     * @param  \Bedard\Photography\Models\Watermark     $watermark
     * @return void
     */
    public function createWatermarks(Watermark $watermark)
    {
        $photoId = $this->id;
        $watermarkId = $watermark->id;
        Queue::push(function($job) use ($photoId, $watermarkId) {
            $photo = Photo::find($photoId);
            $watermark = Watermark::find($watermarkId);
            $image = ImageEditor::createWatermarkedFile($photo, $watermark);
            $photo->watermarkedPhotos()->add($image);
            $job->delete();
        });
    }

    /**
     * Sync watermarked photos
     *
     * @param  \Bedard\Photography\Models\Watermark|null    $watermark
     * @return void
     */
    public function syncWatermarks(Watermark $watermark = null)
    {
        $this->deleteWatermarks();

        if (!is_null($watermark)) {
            $this->createWatermarks($watermark);
        }
    }

    /**
     * Delete all watermarked photos
     *
     * @return void
     */
    public function deleteWatermarks()
    {
        foreach ($this->watermarkedPhotos as $watermarkedPhoto) {
            $watermarkedPhoto->delete();
        }
    }
}
