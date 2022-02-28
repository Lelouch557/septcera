<?php

class Market{

    function get_orders(PDO $db, $id){
        include_once("../../api/controllers/Economy.php");
        $eco = new EconomyController();
        $res = $eco->get_orders($db, $id);

        $orders = "
        <div id='orders_div'>
            <table>
                <th>User</th><th>Offer</th><th>Price</th>";
        for($i=0; $i < count($res); $i++){
            $orders .= "<tr><td>" . $res[$i]["user_name"] . "</td>";
            $orders .= "<td>" . $res[$i]["amount"] . " " . $res[$i]["resource_name"] . "</td>";
            $orders .= "<td>" . $res[$i]["price"] . "</td></tr>";
        }
        $orders .= "</table></div";
        return $orders;
    }

    function get_values(PDO $db){
        include_once("../../api/controllers/Economy.php");
        $eco = new EconomyController();
        $res = $eco->get_values($db);  
        print_r($res);
        $orders = "
        <div id='values_div'>
            <table>
                <th>User</th><th>Value</th>";
        for($i=0; $i < count($res); $i++){
            $orders .= "<tr onclick=\"window.location.href ='market_resource_orders.php?resource_id=" . $res[$i]["id"] . "';\"><td>" . $res[$i]["name"] . "</td>";
            $orders .= "<td>" . $res[$i]["value"] . "</td></tr>";
        }
        $orders .= "</table></div";
        return $orders;
    }
}


?>