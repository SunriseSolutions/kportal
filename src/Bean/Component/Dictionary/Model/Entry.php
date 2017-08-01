<?php
namespace Bean\Component\Dictionary\Model;

use Bean\Component\Dictionary\Model\Base\AbstractEntry;
use Bean\Component\Dictionary\Model\Base\EntryInterface;

/**
 * Created by PhpStorm.
 * User: Binh
 * Date: 7/19/2017
 * Time: 11:06 AM
 */
class Entry extends AbstractEntry {
	
	public function getTranslation($locale = null) {
		if(empty($locale)) {
			return null;
		}
		$counterparts = $this->sense->getEntries();
		/** @var EntryInterface $entry */
		foreach($counterparts as $entry) {
			if($locale === $entry->getLocale()) {
				return $entry;
			}
		}
		
		return null;
	}
	
	public function getFullDescription() {
		return $this->sense->getData();
	}
}