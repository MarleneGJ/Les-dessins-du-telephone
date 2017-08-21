<?php

namespace Lddt\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lddt\UserBundle\Entity\User;

/**
 * Draw
 *
 * @ORM\Table(name="draw")
 * @ORM\Entity(repositoryClass="Lddt\MainBundle\Repository\DrawRepository")
 */
class Draw
{
    /**
     * Plusieurs dessins  (Many) dans (To) une (One) categorie
     * @ORM\ManyToOne(targetEntity="Lddt\MainBundle\Entity\Category")
     * @ORM\JoinColumn(name="id_category",referencedColumnName="id",onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Lddt\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", onDelete="CASCADE")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Lddt\MainBundle\Entity\Color",cascade={"persist"})
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity="Lddt\MainBundle\Entity\Tag",cascade={"persist"})
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity="Lddt\MainBundle\Entity\Comment", mappedBy="draw")
     */
    private $comments;

    /**
     * @ORM\OneToOne(targetEntity="Lddt\MainBundle\Entity\Pic", cascade={"persist"}, inversedBy="draw")
     * @ORM\JoinColumn(name="id_pic",referencedColumnName="id")
     */
    private $pic;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="draw_path", type="string", length=255, nullable=true)
     */
    private $drawPath;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_online", type="boolean")
     */
    private $isOnline;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar_path", type="string", length=255, nullable=true)
     */
    private $avatarPath;

    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="string", length=255, nullable=true)
     */
    private $authorName;

    /**
     * @ORM\Column(name="id_instagram", type="string", length=255, nullable=true)
     */
    private $idInstagram;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Draw
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set drawPath
     *
     * @param string $drawPath
     *
     * @return Draw
     */
    public function setDrawPath($drawPath)
    {
        $this->drawPath = $drawPath;

        return $this;
    }

    /**
     * Get drawPath
     *
     * @return string
     */
    public function getDrawPath()
    {
        return $this->drawPath;
    }

    /**
     * Set isOnline
     *
     * @param boolean $isOnline
     *
     * @return Draw
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    /**
     * Get isOnline
     *
     * @return bool
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * Set avatarPath
     *
     * @param string $avatarPath
     *
     * @return Draw
     */
    public function setAvatarPath($avatarPath)
    {
        $this->avatarPath = $avatarPath;

        return $this;
    }

    /**
     * Get avatarPath
     *
     * @return string
     */
    public function getAvatarPath()
    {
        return $this->avatarPath;
    }

    /**
     * Set authorName
     *
     * @param string $authorName
     *
     * @return Draw
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Draw
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Draw
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set category
     *
     * @param \Lddt\MainBundle\Entity\Category $category
     *
     * @return Draw
     */
    public function setCategory(\Lddt\MainBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Lddt\MainBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct(User $author)
    {
        $this->color = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setAuthor($author);
        $this->setIsOnline(false);
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }


    /**
     * Add color
     *
     * @param \Lddt\MainBundle\Entity\Color $color
     *
     * @return Draw
     */
    public function addColor(\Lddt\MainBundle\Entity\Color $color)
    {
        $this->color[] = $color;

        return $this;
    }

    /**
     * Remove color
     *
     * @param \Lddt\MainBundle\Entity\Color $color
     */
    public function removeColor(\Lddt\MainBundle\Entity\Color $color)
    {
        $this->color->removeElement($color);
    }

    /**
     * Get color
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add comment
     *
     * @param \Lddt\MainBundle\Entity\Comment $comment
     *
     * @return Draw
     */
    public function addComment(\Lddt\MainBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Lddt\MainBundle\Entity\Comment $comment
     */
    public function removeComment(\Lddt\MainBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add tag
     *
     * @param \Lddt\MainBundle\Entity\Tag $tag
     *
     * @return Draw
     */
    public function addTag(\Lddt\MainBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Lddt\MainBundle\Entity\Tag $tag
     */
    public function removeTag(\Lddt\MainBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set pic
     *
     * @param \Lddt\MainBundle\Entity\Pic $pic
     *
     * @return Draw
     */
    public function setPic(\Lddt\MainBundle\Entity\Pic $pic = null)
    {
        $this->pic = $pic;

        return $this;
    }

    /**
     * Get pic
     *
     * @return \Lddt\MainBundle\Entity\Pic
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Set author
     *
     * @param \Lddt\UserBundle\Entity\User $author
     *
     * @return Draw
     */
    public function setAuthor(\Lddt\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Lddt\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set idInstagram
     *
     * @param string $idInstagram
     *
     * @return Draw
     */
    public function setIdInstagram($idInstagram)
    {
        $this->idInstagram = $idInstagram;

        return $this;
    }

    /**
     * Get idInstagram
     *
     * @return string
     */
    public function getIdInstagram()
    {
        return $this->idInstagram;
    }
}
