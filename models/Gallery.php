<?php namespace Bedard\Photography\Models;

use Markdown;
use Model;
use October\Rain\Database\Builder;
use Queue;
use System\Models\File;

/**
 * Gallery Model.
 */
class Gallery extends Model
{
    use \Bedard\Photography\Traits\Subqueryable,
        \October\Rain\Database\Traits\Encryptable,
        \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_photography_galleries';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'description',
        'name',
        'slug',
        'password',
        'photo_price',
        'published_at',
        'watermark_text',
    ];

    /**
     * @var array Attribute casting
     */
    protected $casts = [
        'photo_price' => 'float',
    ];

    /**
     * @var array Date fields
     */
    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Encryptable attributes
     */
    protected $encryptable = [
        'password',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|unique:bedard_photography_galleries',
        'password' => 'between:4,255',
        'photo_price' => 'numeric|min:0',
    ];

    /**
     * @var array Relations
     */
    public $attachMany = [
        'photos' => [
            'Bedard\Photography\Models\Photo',
            'delete' => true,
        ],
    ];

    public $belongsTo = [
        'watermark' => 'Bedard\Photography\Models\Watermark',
    ];

    /**
     * After save.
     *
     * @return void
     */
    public function afterSave()
    {
        $this->commitDeferred($this->sessionKey);
        $this->watermarkPhotos();
    }

    /**
     * Before save.
     *
     * @return void
     */
    public function beforeSave()
    {
        $this->parseDescription();
        $this->purgeWatermarkId();
    }

    /**
     * Return the photo count or zero if undefined. This will only
     * work after joinPhotoCount() has been added to the query.
     *
     * @return int
     */
    public function getPhotoCountAttribute()
    {
        return $this->attributes['photo_count'] ?: 0;
    }

    /**
     * Determine if the gallery is password protected.
     *
     * @return bool
     */
    public function isPasswordProtected()
    {
        return strlen($this->password) > 0;
    }

    /**
     * Parse the description markdown.
     *
     * @return void
     */
    public function parseDescription()
    {
        $this->description_html = Markdown::parse($this->description);
    }

    /**
     * Purge the watermark ID.
     *
     * @return void
     */
    public function purgeWatermarkId()
    {
        if (! $this->is_watermarked) {
            $this->watermark_id = null;
        }
    }

    /**
     * Extend the list query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeJoinPhotoCount(Builder $query)
    {
        $alias = 'system_files';
        $grammar = $query->getQuery()->getGrammar();
        $subquery = File::whereAttachmentType('Bedard\Photography\Models\Gallery')
            ->addselect('system_files.attachment_id')
            ->selectRaw('COUNT('.$grammar->wrap('*').') as '.$grammar->wrap('photo_count'))
            ->groupBy('system_files.attachment_id');

        return $query
            ->addSelect($alias.'.photo_count')
            ->joinSubquery($subquery, $alias, 'bedard_photography_galleries.id', '=', $alias.'.attachment_id', 'leftJoin');
    }

    /**
     * Watermark all photos in the gallery.
     *
     * @return void
     */
    public function watermarkPhotos()
    {
        // @todo: add error handling
        foreach ($this->photos()->get() as $photo) {
            $photoId = $photo->id;
            Queue::push(function ($job) use ($photoId) {
                Photo::findOrFail($photoId)->syncWatermarks();
                $job->delete();
            });
        }
    }
}
