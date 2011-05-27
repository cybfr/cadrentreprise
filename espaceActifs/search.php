<?php

$q = strtolower($_GET["term"]);
if (!$q) return;
		mysql_connect('coudon.miradou.com', 'cadrentreprise_h', 'nLfExyets9dwWYF8');
		mysql_select_db('cadrentreprise_h');
		$result = mysql_query("SET NAMES 'utf8'");
		
		// on fait la requête
		$sql = "SELECT `nom`, `prenom`, `id`
				FROM `tblAdherents`
				WHERE `nom` LIKE '".$q."%' OR `prenom` LIKE '".$q."%' OR `id` LIKE '".$q."%' LIMIT 10";
		$req = mysql_query($sql);
		

function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "\"".addslashes($key)."\"";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}



$result = array();
while($row = mysql_fetch_assoc($req)){
		array_push($result, array("id"=>$row['id'], "label"=>$row['prenom']." <b>".$row['nom']."</b>", "value" => strip_tags($row['prenom']." ".$row['nom'])));
}
echo array_to_json($result);

?>