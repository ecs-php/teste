<?php 
namespace Hmarinjr\RESTFulAPI;

use DateTime;

class BookDTO implements \Serializable
{
    /** 
     * @var int
     */
    private $id;

    /** 
     * @var string
     */
    private $title;

    /** 
     * @var string
     */
    private $author;

    /** 
     * @var \DateTime
     */
    private $launchedAt;

    /** 
     * @var \DateTime
     */
    private $createAt;

    /** 
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct(
        $id,
        $title,
        $author,
        DateTime $createdAt,
        DateTime $launchedAt = null,
        DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->createdAt = $createdAt->format('Y-m-d H:i:s');
        $this->launchedAt = $launchedAt ? $launchedAt->format('Y-m-d') : '';
        $this->updatedAt = $updatedAt ? $updatedAt->format('Y-m-d') : '';
    }

    public function serialize()
    {
        return array_filter([
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'createdAt' => $this->createdAt,
            'launchedAt' => $this->launchedAt,
            'updatedAt' => $this->updatedAt,
            '_links' => [
                'self' => [
                    'href' => '/book/' . $this->id
                ]
            ]
        ]);
    }

    public function unserialize($serialized)
    {
        return (object) $serialized;
    }
}
