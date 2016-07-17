<?php namespace Bedard\Photography\Classes;

use Faker;
use October\Rain\Database\Collection;

abstract class BaseFactory
{
    /**
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * @var October\Rain\Database\Collection
     */
    public $collection;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->collection = new Collection;
        $this->faker = Faker\Factory::create();
    }

    /**
     * Get the default model values.
     *
     * @return array
     */
    abstract public function getDefaults();

    /**
     * Get a new instance of the model being created.
     *
     * @return object
     */
    abstract public function getModel();

    /**
     * Instantiate and save a new model.
     *
     * @param  array    $options
     * @return object
     */
    public function create(array $options = [])
    {
        $model = $this->make($options);
        $model->save();

        return $model;
    }

    /**
     * Instantiate and save a new model.
     *
     * @param  array    $options
     * @return object
     */
    public function forceCreate(array $options = [])
    {
        $model = $this->make($options);
        $model->forceSave();

        return $model;
    }

    /**
     * Instantiate a new model.
     *
     * @param  array    $options
     * @return object
     */
    public function make(array $options = [])
    {
        $model = $this->getModel();
        $model->fill($this->getDefaults());
        $model->fill($options);

        $this->collection->add($model);

        return $model;
    }

    /**
     * Run the create method a given number of times.
     *
     * @param  int  $quantity
     * @return \Bedard\Photography\Classes\BaseFactory
     */
    public function seed($quantity)
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->create();
        }

        return $this;
    }

    /**
     * Run the create method a given number of times.
     *
     * @param  int  $quantity
     * @return \Bedard\Photography\Classes\BaseFactory
     */
    public function forceSeed($quantity)
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->forceCreate();
        }

        return $this;
    }
}
