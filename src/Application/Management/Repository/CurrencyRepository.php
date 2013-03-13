<?php

namespace Application\Management\Repository;

use Jazz\Application;

class CurrencyRepository
{

    public static function getRow(Application $app, $id)
    {
        $sql = "Select * from currency Where id = '" . strtoupper($id) . "'";
        return $app['db']->query($sql)->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param \Jazz\Application $app
     * @return mixed
     */
    public static function getCurrencyList(Application $app)
    {
        $sql = "Select * from currency ";
        return $app['db']->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param \Jazz\Application $app
     * @param array $data
     * @return array|bool
     */
    public static function insertCurrency(Application $app, $data=array())
    {
        $sql = "Insert Into currency ".
            "(id, currency_name, is_active) VALUES ".
            "(:id, :currency_name, :is_active)";

        $query = $app['db']->prepare($sql);
        try {
            $app['db']->beginTransaction();

            $query->bindValue('id', $data['id'], \PDO::PARAM_STR);
            $query->bindValue('currency_name', $data['currency_name'], \PDO::PARAM_STR);
            $query->bindValue('is_active', $data['is_active'], \PDO::PARAM_STR);

            $query->execute();
            $query->commit();
        } catch (\PDOException $e) {
            $app['db']->rollback;
            return array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }

        return false;
    }

    /**
     * @param \Jazz\Application $app
     * @param $id
     * @param array $data
     * @return array
     */
    public function updateCurrency(Application $app, $id, $data=array())
    {
        $sql = "Update currency SET ".
            "id= :id, currency_name= :currency_name, is_active= :is_active ".
            "WHERE id= :id";

        $query = $app['db']->prepare($sql);
        try {
            $app['db']->beginTransaction();

            $app['db']->bindValue('id', $data['id'], \PDO::PARAM_STR);
            $app['db']->bindValue('currency_name', $data['currency_name'], \PDO::PARAM_STR);
            $app['db']->bindValue('is_active', $data['is_active'], \PDO::PARAM_STR);

            $app['db']->bindParam('id',$id, \PDO::PARAM_STR);
            $app['db']->execute();

            $app['db']->commit();
            return array(
                'status' => true,
                'message' => 'Success',
            );
        } catch (\PDOException $e) {
            $app['db']->rollback;
            return array(
                'status' => false,
                'message' => $e->getMessage(),
            );
        }
    }

    /**
     * @param \Jazz\Application $app
     * @param $id
     * @return mixed
     */
    public function deleteCurrency(Application $app, $id)
    {
        return $app['db']->delete('currency', array('id' => $id));
    }

}