<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Infrastructure;

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use App\Infrastructure\ValidationException;

/**
 * Main App Serializer
 *
 * @author mosta <info@manonworld.de>
 */
class AppSerializer {
    
    /**
     *
     * @var EncoderInterface $encoder
     */
    private EncoderInterface $encoder;
    
    /**
     *
     * @var ObjectNormalizer $normalier
     */
    private ObjectNormalizer $normalizer;
    
    /**
     * 
     * @param JsonEncoder $encoder
     * @param ObjectNormalizer $normalizer
     */
    public function __construct(EncoderInterface $encoder, ObjectNormalizer $normalizer)
    {
        $this->encoder      = $encoder;
        $this->normalizer   = $normalizer;
    }
    
    /**
     * 
     * New Instance of the Serializer
     * 
     * @return Serializer
     */
    public function getSerializer(): Serializer
    {
        return new Serializer([$this->normalizer], [$this->encoder]);
    }
    
    
    /**
     * 
     * Deserializes an object
     * 
     * @param mixed $data
     * @param string $object
     * @param string $type
     * @throws ValidationException
     * @return mixed
     */
    public function deserialize($data, string $object, string $type)
    {
        try {
            return $this->getSerializer()->deserialize($data, $object, $type);
        } catch (NotEncodableValueException $e) {
            throw new ValidationException('Invalid Request');
        }
        
    }
    
}
