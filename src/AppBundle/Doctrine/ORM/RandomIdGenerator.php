<?php

namespace AppBundle\Doctrine\ORM;

use Doctrine\ORM\Id\AbstractIdGenerator;

class RandomIdGenerator extends AbstractIdGenerator
{
    public function generate(\Doctrine\ORM\EntityManager $em, $entity)
    {
        $entity_name = $em->getClassMetadata(get_class($entity))->getName();

        $timestamp = base_convert((string)date_timestamp_get(new DateTime()), 10, 32);

        for ($i = 0; $i < 16 - strlen($timestamp);) {
            $timestamp = '0' . $timestamp;
        }

        $tsStr = substr(chunk_split($timestamp, 4, "-"), 0, -1);

//        $tsArray = explode(';;', $tsStr);


        $id = self::generate4DigitCode() .
            '-' . $tsStr
        ; // base_convert($this->id, 10, 32)
        return $id;

        // Should we stop?
//        $attempt++;
//        if ($attempt > $max_attempts) {
//            throw new \Exception('RandomIdGenerator worked hardly, but failed to generate unique ID :(');
//        }

    }

    public static function generate4DigitCode($code = null)
    {
        if ($code === null) {
            $code = base_convert(rand(0, 1048575), 10, 32);
        }
        for ($i = 0; $i < 4 - strlen($code);) {
            $code = '0' . $code;
        }
        return $code;
    }

}