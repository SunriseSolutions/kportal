<?php

namespace AppBundle\Entity\Content\ContentPiece;

use AppBundle\Entity\Content\ContentPiece\Base\AppContentPieceVocabEntry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity
 * @ORM\Table(name="content__pieces_vocab_entries")
 *
 * @Hateoas\Relation(
 *  "self",
 *  href= @Hateoas\Route(
 *         "get_jobs",
 *         parameters = { "user" = "expr(object.getId())"},
 *         absolute = true
 *     ),
 *  attributes = { "method" = {} },
 * )
 *
 */
class ContentPieceVocabEntry extends AppContentPieceVocabEntry {
	function __construct() {
		parent::__construct();
		
	}
	
}
