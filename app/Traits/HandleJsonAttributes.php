<?php

namespace App\Traits;

trait HandleJsonAttributes
{
    public function getJsonAttribute($attribute)
    {
        $value = $this->attributes[$attribute] ?? null;
        
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        
        // Handle JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Set array as JSON string attribute
     */
    public function setJsonAttribute($attribute, $value)
    {
        if (is_array($value)) {
            $this->attributes[$attribute] = json_encode($value);
        } else {
            $this->attributes[$attribute] = null;
        }
    }

    /**
     * Add item to JSON array attribute
     */
    public function addToJsonAttribute($attribute, $value)
    {
        $currentArray = $this->getJsonAttribute($attribute);
        
        if (!in_array($value, $currentArray)) {
            $currentArray[] = $value;
            $this->setJsonAttribute($attribute, $currentArray);
        }
    }

    /**
     * Remove item from JSON array attribute
     */
    public function removeFromJsonAttribute($attribute, $value)
    {
        $currentArray = $this->getJsonAttribute($attribute);
        $currentArray = array_filter($currentArray, function($item) use ($value) {
            return $item != $value;
        });
        
        $this->setJsonAttribute($attribute, array_values($currentArray));
    }

    /**
     * Check if item exists in JSON array attribute
     */
    public function hasInJsonAttribute($attribute, $value)
    {
        $currentArray = $this->getJsonAttribute($attribute);
        return in_array($value, $currentArray);
    }

    /**
     * Get count of items in JSON array attribute
     */
    public function countJsonAttribute($attribute)
    {
        $currentArray = $this->getJsonAttribute($attribute);
        return count($currentArray);
    }

    /**
     * Scope to find records where JSON attribute contains a value
     * Alternative to whereJsonContains for MySQL 5.6
     */
    public function scopeWhereJsonAttributeContains($query, $attribute, $value)
    {
        return $query->where(function($q) use ($attribute, $value) {
            // Handle both string and numeric values
            if (is_string($value)) {
                $q->where($attribute, 'LIKE', '%"' . $value . '"%');
            } else {
                $q->where($attribute, 'LIKE', '%' . $value . '%')
                  ->orWhere($attribute, 'LIKE', '%"' . $value . '"%');
            }
        });
    }

    /**
     * Scope to find records where JSON attribute doesn't contain a value
     */
    public function scopeWhereJsonAttributeDoesntContain($query, $attribute, $value)
    {
        return $query->where(function($q) use ($attribute, $value) {
            $q->whereNull($attribute)
              ->orWhere(function($subQ) use ($attribute, $value) {
                  if (is_string($value)) {
                      $subQ->where($attribute, 'NOT LIKE', '%"' . $value . '"%');
                  } else {
                      $subQ->where($attribute, 'NOT LIKE', '%' . $value . '%')
                           ->where($attribute, 'NOT LIKE', '%"' . $value . '"%');
                  }
              });
        });
    }
}