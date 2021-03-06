<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

//use Illuminate\Validation\Validator;

class MainModel extends Model {

    protected static $validationRules = [];

    protected static $errors;
    protected static $bag;

    public function __construct(array $attributes = []){

        static::$validationRules = $this->rules;
        static::$bag = new MessageBag;
        return parent::__construct($attributes);
    }

    public static function validate($data) {

//        clm($data);

        // make a new validator object
        $v = Validator::make($data, static::$validationRules);
        // check for failure
        if ($v->fails()) {
            // set errors and return false
            self::$errors = $v->errors();
            return false;
        }
        // validation pass

        return true;
    }

    public static function errors() {
        return self::$errors;
    }

    public static function getRules() {
        return static::$validationRules;
    }
//
//    public static function add($params) {
//
//        if (self::validate($params)) {
//            return parent::create($params);
//        } else {
//            return self::errors();
//        }
//    }

    public static function create(array $params = []) {

        if (static::validate($params)) {
            return parent::create($params);
        } else {
            return self::errors();
        }
    }

    public function firstOrCreate(array $params) {

        if (self::validate($params)) {
            return parent::firstOrCreate($params);
        } else {
            return self::errors();
        }
    }

    public function save(array $params = []) {

        if (self::validate(self::getAttributes())) {
            return parent::save();
        } else {
            return self::errors();
        }
    }

}
