<?php namespace Bedard\Photography\Models;

use Image;
use Symfony\Component\Filesystem\Filesystem;
use System\Models\File;

class Photo extends File
{
    /**
     * @var array Hidden fields from array/json access
     */
    protected $hidden = ['attachment_type', 'is_public'];

    /**
     * @var array Relations
     */
    public $attachMany = [
        'watermarkedPhotos' => [
            'System\Models\File',
            'delete' => true,
        ],
    ];

    public $belongsTo = [
        'gallery' => [
            'Bedard\Photography\Models\Gallery',
            'key' => 'attachment_id',
        ],
    ];

    public $belongsToMany = [
        'orders' => [
            'Bedard\Photography\Models\Order',
            'table' => 'bedard_photography_order_photo',
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
        // Create a temporary path and Image instances for our source and watermark
        $tempPath = temp_path("watermark_{$this->getFileName()}");
        $source = Image::make($this->getLocalPath());
        $watermark = Image::make($this->attachment->watermark->image->getLocalPath());

        // Resize the watermark to match the size of the image
        $sourceWidth = $source->width();
        $sourceHeight = $source->height();
        $watermarkWidth = $sourceHeight >= $sourceWidth ? $sourceWidth : null;
        $watermarkHeight = $sourceHeight < $sourceWidth ? $sourceHeight : null;

        $watermark->resize($watermarkHeight, $watermarkWidth, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Insert the watermark in the center of our source image, and save it
        $source->insert($watermark, 'center');
        $source->save($tempPath);

        // Convert that temporary file to a system file
        $files = [];
        $files[] = File::make()->fromFile($tempPath);
        $fs = new Filesystem;
        $fs->remove($tempPath);

        // Create watermark versions at our given sizes
        foreach (Settings::getWatermarkSizes() as $width) {
            $resizedPath = temp_path('watermark_'.$width.'_'.$this->getFileName());
            $resizedWatermark = $source->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $source->save($resizedPath);
            $files[] = File::make()->fromFile($resizedPath);
            $fs->remove($tempPath);
        }

        return $files;
    }

    /**
     * Create watermarked photos.
     *
     * @return void
     */
    public function createWatermarks()
    {
        foreach ($this->createWatermarkedPhoto() as $file) {
            $this->watermarkedPhotos()->add($file);
        }
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
