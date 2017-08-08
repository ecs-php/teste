<?php
    /**
     * @author Cristiano Azevedo <cristianodasilva.azevedo@gmail.com>
     */

    namespace App\Filter;


    use Zend\InputFilter\InputFilter;

    class User extends InputFilter
    {
        public function __construct()
        {
            $this->add([
                'name' => 'name',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags']
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                    ],
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 2,
                            'max' => 255
                        ],
                    ],
                ],
            ]);

            $this->add([
                'name' => 'country',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags']
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                    ],
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 2,
                            'max' => 255
                        ],
                    ],
                ],
            ]);

            $this->add([
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags']
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                    ],
                    [
                        'name' => 'EmailAddress',
                    ],
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'max' => 255
                        ],
                    ],
                ],
            ]);

            $this->add([
                'name' => 'age',
                'required' => true,
                'validators' => [
                    [
                        'name' => 'NotEmpty',
                    ],[
                        'name' => 'Digits',
                    ],
                ],
            ]);
        }
    }