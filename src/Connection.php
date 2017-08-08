<?php
    /**
     * @author Cristiano Azevedo <cristianodasilva.azevedo@gmail.com>
     */

    namespace App;


    class Connection
    {

        public static $entityManager = null;

        private function __construct()
        {

        }

        /**
         * @return \Doctrine\ORM\EntityManager
         */
        public static function getEntityManager()
        {

            if (self::$entityManager == null) {

                $entities = array('./Entity');
                $devMode = true;

                $parametersDB = array(
                    "host" => "localhost",
                    "driver" => "pdo_mysql",
                    "user" => "root",
                    "password" => "usbw",
                    "dbname" => "dev_serasa",
                    'charset' => 'utf8',
                    'port'     => '3307',
                );

                $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($entities, $devMode);
                self::$entityManager = \Doctrine\ORM\EntityManager::create($parametersDB, $config);
            }

            return self::$entityManager;
        }

    }