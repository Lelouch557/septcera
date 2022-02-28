<?php
class Market_order{
    public $id;
    public $host_id;
    public $resource_id;
    public $price;
    public $amount;
    public $is_buy_order;
    public $is_continuous_order;
}


class EconomyController{
    public static function place_order(PDO $db, $host_id, $resource_id, $price, $amount, $is_buy_order, $is_continuous_order){
        $query = $db->prepare("INSERT INTO `market_order`(`host_id`, `resource_id`, `price`, `amount`, `is_buy_order`, `is_continuous_order`) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bindParam(1, $host_id, PDO::PARAM_INT);
        $query->bindParam(2, $resource_id, PDO::PARAM_INT);
        $query->bindParam(3, $price, PDO::PARAM_INT);
        $query->bindParam(4, $amount, PDO::PARAM_INT);
        $query->bindParam(5, $is_buy_order, PDO::PARAM_INT);
        $query->bindParam(6, $is_continuous_order, PDO::PARAM_INT);
        if($query->execute()){
            throw new Response("Buy order added", 200);
        }else{
            throw new Response("failed", 409);
        }
    }
    
    public static function accept_order(PDO $db, $order_id, $resource_id){
        $query = $db->prepare("SELECT * from `market_order` where id = ?");
        $query->bindParam(1,$order_id, PDO::PARAM_INT);
        if($query->execute()){
            $order = $query->fetchObject(Market_order::class);

            $query = $db->prepare("SELECT amount FROM `storage_resource` as sr
            inner join `storage` as s on s.id = sr.storage_id
            inner join `resource` as r on r.id = sr.resource_id
            WHERE s.village_id = ? and r.id = ?
            ");
            $query->bindParam(1, $_SESSION['village_id'], PDO::PARAM_INT);
            $query->bindParam(2, $resource_id, PDO::PARAM_INT);
            if($query->execute()){
                $res = $query->fetchAll(PDO::FETCH_ASSOC);

                if($res[0]['amount'] >= $order->price){
                    $query = $db->prepare("INSERT INTO `market_order_in_transit`( `host_id`, `target_id`, `resource_id`, `amount`) VALUES ( ?, ?, ?, ? )");
                    $query->bindParam(1, $order->host_id, PDO::PARAM_INT);
                    $query->bindParam(2, $_SESSION['village_id'], PDO::PARAM_INT);
                    $query->bindParam(3, $order->resource_id, PDO::PARAM_INT);
                    $query->bindParam(4, $order->amount, PDO::PARAM_INT);
                    if($query->execute()){
                        $query = $db->prepare("DELETE from market_order where id = ?");
                        $query->bindParam(1, $order->id, PDO::PARAM_INT);
                        if($query->execute()){

                            $left_resources = $res[0]['amount'] - $order->price;
                            $query = $db->prepare("UPDATE `storage_resource` as sr 
                            inner join `storage` as s on s.id = sr.storage_id
                            SET `amount` = ?
                            WHERE s.village_id = ? and sr.resource_id = ?");
                            $query->bindParam(1, $left_resources, PDO::PARAM_INT);
                            $query->bindParam(2, $_SESSION['Village_ID'], PDO::PARAM_INT);
                            $query->bindParam(3, $resource_id, PDO::PARAM_INT);
                            if($query->execute()){
                                throw new Response("resouces bought", 200);
                            }
                        }
                    }
                }else{
                    throw new Response("not enough resources", 409);
                }
            }
        }
        throw new Response("failed", 409);
    }

    public static function get_orders(PDO $db, $id){
        $query = $db->prepare(
            "SELECT u.name as user_name, mo.price, mo.amount, r.name as resource_name FROM `market_order` as mo 
            inner join `village` as v on mo.host_id = v.id
            inner join `user_village` as uv on uv.village_id = v.id
            inner join `user` as u on uv.user_id = u.id
            inner join `resource` as r on r.id = mo.resource_id
            where r.id = ?");
        $query->bindParam(1, $id, PDO::PARAM_INT);
            
        if($query->execute()){
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            try{
                throw new Response($res, 200);
            }catch(Error $e){
                return $res;
            }
        }else{
            try{
                throw new Response("failed", 409);
            }catch(Error $e){
                return ["Failed"];
            }
            
        }

    }
    
    public static function get_values(PDO $db){
        $query = $db->prepare("SELECT * from `resource`");
            
        if($query->execute()){
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            try{
                throw new Response($res, 200);
            }catch(Error $e){
                return $res;
            }
        }else{
            try{
                throw new Response("failed", 409);
            }catch(Error $e){
                return ["Failed"];
            }
            
        }

    }
    
    public static function accept_continuous_order(PDO $db, $order_id, $order_type, $amount){}
    public static function send_continuous_order(PDO $db){}
    public static function send_one_time_order(PDO $db){}
}
?>