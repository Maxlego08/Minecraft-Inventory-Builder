<?php


namespace App\Payment\utils\Resources;


use App\Models\Resource\Resource;
use App\Models\User;

class ResourceDownload
{

    /**
     * @var Resource
     */
    public Resource $resource;

    /**
     * @var User
     */
    public User $user;

    /**
     * ResourceCreate constructor.
     * @param Resource $resource
     * @param User $user
     */
    public function __construct(Resource $resource, User $user)
    {
        $this->resource = $resource;
        $this->user = $user;
    }


}
