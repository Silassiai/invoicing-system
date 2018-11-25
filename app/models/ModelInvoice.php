<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25-11-2018
 * Time: 0:25
 */
namespace models;

use core\ModelCore as ModelCore;
use PDO;

class ModelInvoice extends ModelCore
{
    public function getInvoices() {
        $query = 'SELECT i.id, i.client, count(ii.id) 
                    FROM `invoices` i
                    JOIN invoice_items ii ON i.id = ii.invoice_id
                    GROUP BY i.id';

        $sql = $this->db->prepare($query);

        if ( ! $sql->execute() ) {
            die(json_encode($sql->errorInfo()));
        }
        return $sql->fetchAll( PDO::FETCH_OBJ );
    }
}