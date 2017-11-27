<?php

    namespace Classes\Webforce3\DB;

    use Classes\Webforce3\Config\Config;

    class Session extends DbObject {
        /**
         * @param int $id
         * @return DbObject
         */
        public static function get($id) {
            // TODO: Implement get() method.
        }

        /**
         * @return DbObject[]
         */
        public static function getAll() {
            // TODO: Implement getAll() method.
        }

        /**
         * @return array
         */
        public static function getAllForSelect()
        {
            $returnList = array();

            $sql = '
                SELECT ses_id, tra_name, ses_start_date, ses_end_date, loc_name
                FROM session
                LEFT OUTER JOIN training ON training.tra_id = session.training_tra_id
                LEFT OUTER JOIN location ON location.loc_id = session.location_loc_id
                WHERE ses_id > 0
                ORDER BY ses_start_date ASC
            ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
            }
            else {
                $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($allDatas as $row) {
                    $returnList[$row['ses_id']] = '['.$row['ses_start_date'].' > '.$row['ses_end_date'].'] '.$row['tra_name'].' - '.$row['loc_name'];
                }
            }

            return $returnList;
        }

        /**
         * @param int $sessionId
         * @return DbObject[]
         */
        public static function getFromSession($sessionId) {
            // TODO: Implement getFromTraining() method.
        }

        /**
         * @return bool
         */
        public function saveDB() {
            // TODO: Implement saveDB() method.
        }

        /**
         * @param int $id
         * @return bool
         */
        public static function deleteById($id) {
            // TODO: Implement deleteById() method.
        }

    }