<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GlobalModel extends Model
{
    protected static $entityField = 'entity_id';

    protected static function boot()
    {
        parent::boot();
        $entityField = static::$entityField;
        if(!empty($entityField)){
            static::addGlobalScope('entity', function(Builder $builder) use($entityField) {
                $user_entity = static::getUserEntity();
                if($user_entity) {
                    $builder->where(function($q) use ($user_entity, $entityField) {
                        $model = new static();
                        $entityWhere = $model->getTable().".".$entityField;
                        $q->where($entityWhere, '=', $user_entity);
                        $q->orWhereNull($entityWhere);
                    });
                }
            });
        }
    }

    protected function performInsert(Builder $query, array $options = [])
    {
        if(!empty(static::$entityField))
        {
            $this->attributes[static::$entityField] = static::getUserEntity();
        }

        parent::performInsert($query, $options);
    }

    protected static function getUserEntity()
    {
        return \Auth::user() ? \Auth::user()->entity->id : null;
    }

    // RELATIONS

    public function entity() {
        if(static::$entityField) {
            return $this->hasOne(Entity::class);
        }

        return null;
    }

    // END RELATIONS
}
