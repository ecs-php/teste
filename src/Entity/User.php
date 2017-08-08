<?php
    /**
     * @author Cristiano Azevedo <cristianodasilva.azevedo@gmail.com>
     */

    namespace App\Entity;

    use Zend\Hydrator\ClassMethods;
    use Zend\Hydrator\HydratorInterface;

    /**
     * @Entity
     * @Table(name="user")
     */
    class User implements HydratorInterface
    {
        /**
         * @var int
         *
         * @Id
         * @GeneratedValue(strategy="AUTO")
         * @Column(name="id", type="integer", nullable=false)
         */
        private $id;
        /**
         * @var string
         *
         * @Column(name="name", type="string", length=255, nullable=false)
         */
        private $name;
        /**
         * @var string
         *
         * @Column(name="email", type="string", length=255, nullable=false)
         */
        private $email;
        /**
         * @var string
         *
         * @Column(name="country", type="string", length=255, nullable=false)
         */
        private $country;
        /**
         * @var integer
         *
         * @Column(name="age", type="integer", nullable=false)
         */
        private $age;
        /**
         * @var \DateTime
         *
         * @Column(name="created", type="datetime", nullable=false)
         */
        private $created;
        /**
         * @var \DateTime
         *
         * @Column(name="updated", type="datetime", nullable=true)
         */
        private $updated;

        private $hydrator;

        public function __construct()
        {
            $this->created = new \DateTime();
            $this->hydrator = new ClassMethods();
        }

        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param int $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * @param string $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @return string
         */
        public function getCountry()
        {
            return $this->country;
        }

        /**
         * @param string $country
         */
        public function setCountry($country)
        {
            $this->country = $country;
        }

        /**
         * @return int
         */
        public function getAge()
        {
            return $this->age;
        }

        /**
         * @param int $age
         */
        public function setAge($age)
        {
            $this->age = $age;
        }

        /**
         * @return \DateTime
         */
        public function getCreated($format = 'd/m/Y H:i:s')
        {
            if ($this->created instanceof \DateTime) {
                return $this->created->format($format);
            }
        }

        /**
         * @param \DateTime $created
         */
        public function setCreated($created)
        {
            $this->created = $created;
        }

        /**
         * @return \DateTime
         */
        public function getUpdated($format = 'd/m/Y H:i:s')
        {
            if ($this->updated instanceof \DateTime) {
                return $this->updated->format($format);
            }
        }

        /**
         * @param \DateTime $updated
         */
        public function setUpdated($updated)
        {
            $this->updated = $updated;
        }

        /**
         * Extract values from an object
         *
         * @param  object $object
         * @return array
         */
        public function extract($object)
        {
            $values = $this->hydrator->extract($object);

            return $values;
        }

        /**
         * Hydrate $object with the provided $data.
         *
         * @param  array $data
         * @param  object $object
         * @return object
         */
        public function hydrate(array $data, $object)
        {
            return $this->hydrator->hydrate($data, $object);
        }
    }