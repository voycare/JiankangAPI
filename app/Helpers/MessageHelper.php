<?php
/**
 * Created by PhpStorm.
 * User: dinhln
 * Date: 8/11/20
 * Time: 11:02
 */

namespace App\Helpers;

use App\Models\MessageState;

class MessageHelper
{
    /**
     * @param $query
     * @param string $type
     * @return mixed
     */
    public static function index($query, $type = '')
    {
        switch ($type) {
            case 'draft':
                $query = $query->whereHas('states', function ($q) {
                    return $q->where('state', MessageState::STATE_DRAFT);
                });
                break;
            case 'trash':
                $query = $query->whereHas('states', function ($q) {
                    return $q->where('state', MessageState::STATE_TRASH);
                });
                break;
            case 'sent':
                $query = $query->whereHas('states', function ($q) {
                    return $q->where('state', '!=', MessageState::STATE_DRAFT);
                });
                break;
        }

        return $query;
    }
}