<?php
namespace AppBundle\Entity\Media;

use AppBundle\Entity\CandidateAnswer;
use AppBundle\Entity\JobCandidate;
use Application\Sonata\UserBundle\Entity\User;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;
use AppBundle\Entity\Organisation;
use Doctrine\Common\Collections\ArrayCollection;

class BaseAppMedia extends BaseMedia
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var Media
     */
    protected $thumbnail;

    /**
     * @var User
     */
    protected $avatarUser;

    /**
     * @var CandidateAnswer
     */
    protected $videoAnswer;

    /**
     * @var ArrayCollection JobCandidate
     */
    protected $resumeCandidates;

    /**
     * @var ArrayCollection
     */
    protected $introVideos;

    /**
     * @var Organisation
     */
    protected $logoOrganisation;

    /**
     * @var ArrayCollection
     */
    protected $bannerOrganisations;


    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Organisation
     */
    public function getLogoOrganisation()
    {
        return $this->logoOrganisation;
    }

    /**
     * @param Organisation $logoOrganisation
     */
    public function setLogoOrganisation($logoOrganisation)
    {
        $this->logoOrganisation = $logoOrganisation;
    }

    /**
     * @return ArrayCollection
     */
    public function getBannerOrganisations()
    {
        return $this->bannerOrganisations;
    }

    /**
     * @param ArrayCollection $bannerOrganisations
     */
    public function setBannerOrganisations($bannerOrganisations)
    {
        $this->bannerOrganisations = $bannerOrganisations;
    }

    /**
     * @return ArrayCollection
     */
    public function getIntroVideos()
    {
        return $this->introVideos;
    }

    /**
     * @param ArrayCollection $introVideos
     */
    public function setIntroVideos($introVideos)
    {
        $this->introVideos = $introVideos;
    }

    /**
     * @return ArrayCollection
     */
    public function getResumeCandidates()
    {
        return $this->resumeCandidates;
    }

    /**
     * @param ArrayCollection $resumeCandidates
     */
    public function setResumeCandidates($resumeCandidates)
    {
        $this->resumeCandidates = $resumeCandidates;
    }

    /**
     * @return Media
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param Media $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return User
     */
    public function getAvatarUser()
    {
        return $this->avatarUser;
    }

    /**
     * @param User $avatarUser
     */
    public function setAvatarUser($avatarUser)
    {
        $this->avatarUser = $avatarUser;
    }

    /**
     * @return CandidateAnswer
     */
    public function getVideoAnswer()
    {
        return $this->videoAnswer;
    }

    /**
     * @param CandidateAnswer $videoAnswer
     */
    public function setVideoAnswer($videoAnswer)
    {
        $this->videoAnswer = $videoAnswer;
    }


}