<?php

namespace AppBundle\Entity\Dictionary;

use AppBundle\Entity\Dictionary\Base\AppEntry;
use AppBundle\Entity\Dictionary\Base\AppEntryExample;
use AppBundle\Entity\Dictionary\Base\AppEntryUsage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="dictionary__entries_usages")
 *
 */
class EntryUsage extends AppEntryUsage {
	
	public function getTitle() {
		return $this->getEntry()->getPhrase() . ' > ' . $this->getUsage()->getPhrase();
	}
	
}