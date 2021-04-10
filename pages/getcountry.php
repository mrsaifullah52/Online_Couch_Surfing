<?php



if(isset($_GET['req'])){

  if($_GET['req'] == "country"){
    countries();
  }else if($_GET['req'] == "city"){
    if(isset($_GET['country'])){
      cities($_GET['country']);
    }
  }else{
    echo "Failed to get it.";
  }

}


function countries(){
  $countries=array();
  $json = file_get_contents("../resource/countriesToCities.json");
  if ($json === false) {
    echo "Failed to retrieve file.";
  }

  $json_a = json_decode($json, true);
  if ($json_a === null) {    
    echo "Failed to convert file.";
  }

  foreach ($json_a as $country_name => $city_name) {
    array_push($countries, $country_name);
  }
  echo json_encode($countries);
}

function cities($country){
  $cities=array();
  $json = file_get_contents("../resource/countriesToCities.json");
  if ($json === false) {
    echo "Failed to retrieve file.";
  }

  $json_a = json_decode($json, true);
  if ($json_a === null) {    
    echo "Failed to convert file.";
  }

  foreach($json_a[$country] as $city){
    array_push($cities, $city);
  }
  echo json_encode($cities);
}

?>