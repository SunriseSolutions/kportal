<?php

namespace AppBundle\Entity\Dictionary;

use AppBundle\Entity\Dictionary\Base\AppEntry;
use AppBundle\Entity\Dictionary\Base\AppEntryExample;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="dictionary__entries_examples")
 *
 */
class EntryExample extends AppEntryExample {
	
	public function getTitle() {
		return $this->getEntry()->getPhrase() . ' > ' . $this->getExample()->getPhrase();
	}
	
}