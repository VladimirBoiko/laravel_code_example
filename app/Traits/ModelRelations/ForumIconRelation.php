<?php

namespace App\Traits\ModelRelations;


trait ForumIconRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forum_topics()
    {
        return $this->hasMany('App\ForumTopic');
    }
}