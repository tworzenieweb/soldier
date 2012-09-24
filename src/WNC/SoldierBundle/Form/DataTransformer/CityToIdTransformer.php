<?php


namespace WNC\SoldierBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use WNC\SoldierBundle\Entity\City;

class CityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (coty) to a integer (id).
     *
     * @param  City|null $issue
     * @return string
     */
    public function transform($city)
    {
        if (null === $city) {
            return "";
        }

        return $city->getName();
    }

    /**
     * Transforms a string (name) to an object (city).
     *
     * @param  string $name
     * @return City|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }
        
        $city = $this->om
            ->getRepository('WNCSoldierBundle:City')
            ->findOneBy(array('name' => $name))
        ;

        if (null === $city) {
            $city = new City();
            $city->setName($name);
            $this->om->persist($city);
            
            
        }

        return $city;
    }
}