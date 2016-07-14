<?php namespace Bedard\Photography\Models;

use Markdown;
use Model;
use October\Rain\Database\Builder;
use System\Models\File;

/**
 * Gallery Model
 */
class Gallery extends Model
{
    use \Bedard\Photography\Traits\Subqueryable,
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
        'photo_price',
        'published_at',
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
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|unique:bedard_photography_galleries',
        'photo_price' => 'numeric|min:0',
    ];

    /**
     * @var array Relations
     */
    public $attachMany = [
        'photos' => 'System\Models\File'
    ];

    /**
     * Before save
     *
     * @return void
     */
    public function beforeSave()
    {
        $this->parseDescription();
    }

    /**
     * Parse the description markdown
     *
     * @return void
     */
    public function parseDescription()
    {
        $this->description_html = Markdown::parse($this->description);
    }

    /**
     * Extend the list query
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
            ->selectRaw('COUNT(' . $grammar->wrap('*') . ') as ' . $grammar->wrap('photo_count'))
            ->groupBy('system_files.attachment_id');

        return $query
            ->addSelect($alias . '.photo_count')
            ->joinSubquery($subquery, $alias, 'bedard_photography_galleries.id', '=', $alias . '.attachment_id');
    }
}
