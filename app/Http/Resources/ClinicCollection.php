<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class ClinicCollection extends ResourceCollection
{
    private $type = '';

    /**
     * Create a new resource instance.
     *
     * @param  mixed $resource
     * @return void
     */
    public function __construct($resource, $type = '')
    {
        $this->type = $type;
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        $next_page = $this->currentPage() + 1;
        if ($next_page > $this->lastPage()) {
            $next_page = 0;
        }

        $datas = ClinicResource::collection($this->collection);

        return [
            'datas' => $datas,
            'next_page' => $next_page,
            'total_page' => $this->lastPage(),
            'total' => $this->total()
        ];
    }
}
