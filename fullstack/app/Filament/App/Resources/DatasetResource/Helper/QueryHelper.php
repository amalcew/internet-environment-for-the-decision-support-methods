<?php

namespace App\Filament\App\Resources\DatasetResource\Helper;

class QueryHelper
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public static function adjustQueryForDatasetAccess($query)
    {
//        direct members
        $query->where(function ($query) {
            $query->whereRelation('directMembers', 'datasetable_id', '=', auth()->id())
//            members of a group
                ->orWhereRelation('groups', function ($query) {
                    $query->whereHas('users', function ($query) {
                        $query->where('id', '=', auth()->id());
                    });
                });
        });

        return $query;
    }
}
