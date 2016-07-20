<?php namespace Bedard\Photography\Models;

use Image;
use Symfony\Component\Filesystem\Filesystem;
use System\Models\File;

class Photo extends File
{
    /**
     * @var array Relations
     */
    public $attachMany = [
        'watermarkedPhotos' => [
            'System\Models\File',
            'delete' => true,
        ],
    ];

    /**
     * Construct.
     */
    public function __construct()
    {
        parent::__construct();

        // Events are bound here to avoid collisions with \System\Models\File
        static::extend(function ($model) {
            $model->bindEvent('model.afterDelete', function () use ($model) {
                $model->deleteWatermarks();
            });
        });
    }

    /**
     * Create a watermarked version of a photo.
     *
     * @return \System\Models\File
     */
    public function createWatermarkedPhoto()
    {
        // Create a temporary file with the watermark
        $tempPath = temp_path("watermark_{$this->getFileName()}");
        $image = Image::make($this->getLocalPath());
        $image->insert($this->attachment->watermark->image->getLocalPath());
        $image->save($tempPath);

        // Convert that temporary file to a system file and clean up our mess
        $file = File::make()->fromFile($tempPath);
        $fs = new Filesystem;
        $fs->remove($tempPath);

        return $file;
    }

    /**
     * Create watermarked photos.
     *
     * @return void
     */
    public function createWatermarks()
    {
        $image = $this->createWatermarkedPhoto();
        $this->watermarkedPhotos()->add($image);
    }

    /**
     * Sync watermarked photos.
     *
     * @return void
     */
    public function syncWatermarks()
    {
        $this->deleteWatermarks();
        $this->load('attachment.watermark.image');
        if (! is_null($this->attachment->watermark_id)) {
            $this->createWatermarks();
        }
    }

    /**
     * Delete all watermarked photos.
     *
     * @return void
     */
    public function deleteWatermarks()
    {
        foreach ($this->watermarkedPhotos()->get() as $watermarkedPhoto) {
            $watermarkedPhoto->delete();
        }
    }
}
