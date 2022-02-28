<?php


class ResourceController{

    public static function increment_resources(PDO $db){
        
        $query = $db->prepare("SELECT timestamp from storage_resource where id=1");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $d1 = new DateTime();
        $d1 = $d1->format("Y-m-d H:00:00");
        $d1 = new DateTime($d1);
        $d2 = new DateTime($result[0]['timestamp']);

        $interval = floor(($d1->getTimestamp() - $d2->getTimestamp()) / 3600);
        
        if($interval >= 1){
            $date_to_db = $d1->format("Y-m-d H:00:00");

            $query = $db->prepare("call increment_resource(?, ?)");
            $query->bindPARAM(1, $date_to_db, PDO::PARAM_STR);
            $query->bindPARAM(2, $interval, PDO::PARAM_INT);
            if($query->execute()) {
                throw new  Response("resources incremented");
            }
        }
        throw new  Response("resources not incremented");
    }
}
/*

update `storage_resource` as st SET 
`timestamp` = CURRENT_TIMESTAMP,
`amount` = (SELECT IF(
    TIMESTAMPDIFF(SECOND, timestamp, CURRENT_TIMESTAMP) > 1800,
    IF(
        generation + amount < max_amount,
        generation * floor(TIMESTAMPDIFF(SECOND, timestamp, CURRENT_TIMESTAMP)/1800) + amount,
        max_amount ),
    amount) 
FROM `storage_resource`as st2 where st.resource_id = st2.resource_id AND st.storage_id = st2.storage_id)
*/
?>