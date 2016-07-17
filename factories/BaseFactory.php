<?php namespace Bedard\Photography\Factories;

use Faker;

abstract class BaseFactory
{
    /**
     * @var Faker\Factory   $faker
     */
    protected $faker;

    /**
     * Construct.
     */
    public function __construct()
    {
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

        return $model;
    }

    /**
     * Run the create method a given number of times.
     *
     * @param  integer  $quantity
     * @return void
     */
    public function seed($quantity)
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->create();
        }
    }
}
