<?php

    namespace Classes\Webforce3\DB;

    use Classes\Webforce3\Config\Config;
    use Classes\Webforce3\Exceptions\InvalidSqlQueryException;

    class Country extends DbObject
    {
        /** @var string */
        protected $name;

        public function __construct($id = 0, $name = '', $inserted = '')
        {
            $this->name = $name;

            parent::__construct($id, $inserted);
        }

        /**
         * @param int $id
         * @return bool|Student
         * @throws InvalidSqlQueryException
         */
        public static function get($id)
        {
            $sql = '
                SELECT cou_id, cou_name
                FROM country
                WHERE cou_id = :id
                ORDER BY cou_name ASC
            ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

            if ($stmt->execute() === false)
            {
                throw new InvalidSqlQueryException($sql, $stmt);
            }
            else
            {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                if (!empty($row))
                {
                    $currentObject = new Country(
                        $row['cou_id'],
                        $row['cou_name']
                    );
                    return $currentObject;
                }
            }
            return false;
        }

        /**
         * @return DbObject[]
         * @throws InvalidSqlQueryException
         */
        public static function getAll()
        {
            $returnList = [];

            $sql = '
                SELECT cou_id, cou_name
                FROM country
                WHERE cou_id > 0
                ORDER BY cou_name ASC
            ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            if ($stmt->execute() === false)
            {
                throw new InvalidSqlQueryException($sql, $stmt);
            }
            else
            {
                $allData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($allData as $row)
                {
                    $currentObject = new Country(
                        $row['cou_id'],
                        $row['cou_name']
                    );
                    $returnList[] = $currentObject;
                }
            }
            return $returnList;
        }

        /**
         * @return array
         * @throws InvalidSqlQueryException
         */
        public static function getAllForSelect()
        {
            $returnList = [];

            $sql = '
                SELECT cou_id, cou_name
                FROM country
                WHERE cou_id > 0
                ORDER BY cou_name ASC
            ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            if ($stmt->execute() === false)
            {
                throw new InvalidSqlQueryException($sql, $stmt);
            }
            else
            {
                $allData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($allData as $row) {
                    $returnList[$row['cou_id']] = $row['cou_name'];
                }
            }
            return $returnList;
        }

        /**
         * @return bool
         * @throws InvalidSqlQueryException
         */
        public function saveDB()
        {
            if ($this->id > 0) {
                $sql = '
                    UPDATE country
                    SET cou_name = :name
                    WHERE cou_id = :id
                ';
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':name', $this->name, \PDO::PARAM_STR);
                $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);

                if ($stmt->execute() === false)
                {
                    throw new InvalidSqlQueryException($sql, $stmt);
                }
                else
                {
                    return true;
                }
            }
            else
            {
                $sql = '
                    INSERT INTO country (cou_name)
                    VALUES (:name)
                ';
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':name', $this->name, \PDO::PARAM_STR);

                if ($stmt->execute() === false)
                {
                    throw new InvalidSqlQueryException($sql, $stmt);
                }
                else
                {
                    $this->id = Config::getInstance()->getPDO()->lastInsertId();
                    return true;
                }
            }
            return false;
        }

        /**
         * @param int $id
         * @return bool
         * @throws InvalidSqlQueryException
         */
        public static function deleteById($id)
        {
            $sql = '
                DELETE FROM country WHERE cou_id = :id
            ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

            if ($stmt->execute() === false)
            {
                print_r($stmt->errorInfo());
            }
            else
            {
                return true;
            }
            return false;
        }

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }
    }