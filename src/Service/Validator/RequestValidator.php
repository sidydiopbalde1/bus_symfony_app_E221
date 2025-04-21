<?php

namespace App\Service\Validator;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class RequestValidator
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    public function validate(string $json, string $dtoClass): object
    {
        $dto = $this->serializer->deserialize($json, $dtoClass, 'json');
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new BadRequestHttpException(json_encode($messages));
        }

        return $dto;
    }
}
