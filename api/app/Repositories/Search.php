<?php

namespace App\Repositories;

use App\Repositories\Elasticsearch\ElasticsearchRepositoryModelInterface;

class Search implements ElasticsearchRepositoryModelInterface
{
    const TYPE_NEWS = 'news';
    const TYPE_TWITTER = 'twitter';
    const TYPE_INSTAGRAM = 'instagram';

    const SOURCE_CNN = 'CNN';
    const SOURCE_BBC = 'BBC';
    const SOURCE_NBC = 'NBC';
    const SOURCE_CBS = 'CBS';


    private string $type;
    private ?string $id = null;
    private ?string $title = null;
    private ?string $source = null;
    private ?string $content = null;
    private ?string $link = null;
    private ?string $avatar = null;
    private ?string $photo = null;
    private ?string $video = null;
    private ?string $name = null;
    private ?string $username = null;
    private ?string $retweet = null;
    private ?string $date = null;


    public function toArray()
    {
        $required = [
            'type' => $this->type,
        ];
        $optional = [
            'id' => $this->id,
            'title' => $this->title,
            'source' => $this->source,
            'content' => $this->content,
            'link' => $this->link,
            'avatar' => $this->avatar,
            'photo' => $this->photo,
            'video' => $this->video,
            'name' => $this->name,
            'username' => $this->username,
            'retweet' => $this->retweet,
            'date' => $this->date,
        ];
        foreach ($optional as $key => $value) {
            if ( !is_null($value) ) {
                $required[$key] = $value;
            }
        }
        return $required;
    }



    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return Search
     */
    public function setId(?string $id): Search
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     * @return Search
     */
    public function setDate(?string $date): Search
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Search
     */
    public function setType(string $type): Search
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Search
     */
    public function setTitle(?string $title): Search
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string|null $source
     * @return Search
     */
    public function setSource(?string $source): Search
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return Search
     */
    public function setContent(?string $content): Search
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     * @return Search
     */
    public function setLink(?string $link): Search
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     * @return Search
     */
    public function setAvatar(?string $avatar): Search
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string|null $photo
     * @return Search
     */
    public function setPhoto(?string $photo): Search
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param string|null $video
     * @return Search
     */
    public function setVideo(?string $video): Search
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Search
     */
    public function setName(?string $name): Search
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return Search
     */
    public function setUsername(?string $username): Search
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRetweet(): ?string
    {
        return $this->retweet;
    }

    /**
     * @param string|null $retweet
     * @return Search
     */
    public function setRetweet(?string $retweet): Search
    {
        $this->retweet = $retweet;
        return $this;
    }
}
