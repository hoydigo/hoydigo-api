<?php


namespace App\Classes\Twitter;


use Illuminate\Http\Client\Response;
use phpDocumentor\Reflection\Types\Boolean;

class TwitterUserEntity
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $image_url;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $username;

    /**
     * @var bool
     */
    private $verified;

    /**
     * TwitterUserEntity constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $data = json_decode($response->body())->data;

        $this->id = $data->id;
        $this->username = $data->username;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->url = $data->url;
        $this->image_url = str_replace('_normal', '', $data->profile_image_url);
        $this->location = $data->location;
        $this->verified = $data->verified;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return bool
     */
    public function getVerified(): bool
    {
        return $this->verified;
    }


}
