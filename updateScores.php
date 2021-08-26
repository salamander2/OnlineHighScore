<?php
/***************************************
Name: updateScores.php
Function: will read in all scores and add new score in correct position
          will update player's score to new higher score
          will write out only the top 10 scores
          must be authorized with correct code: "zednn" where nn is today's date
Usage: updateScores.php?AUTH=zed25&NAME=Fred&SCORE=12354
Notes:  filename: HiScores.txt
        all names are capitalized
        format of record in file:  name,score
***************************************/
error_reporting(E_ALL);

function removeWhiteSpace($text)
{
    $text = trim($text);
    //$text = trim(strip_tags(addslashes($text)));
    $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
    $text = preg_replace('/([\s])\1+/', ' ', $text);
    $text = trim($text);
    return $text;
}

$auth=$newname = $newscore = ""; 
$auth = $_GET['AUTH']; 
$newname = removeWhiteSpace($_GET['NAME']); 
$newscore= removeWhiteSpace($_GET['SCORE']);

# print($newname."<br>"); //DEBUG
# print($newscore."<br>"); //DEBUG

if ($auth != "zed". date("d")) {
    die("Error: invalid auth code");
}

if (empty($newname) || empty($newscore)) {
   die("Error, missing data");
}

if (!is_numeric($newscore)) {
    die("score must be numeric");
}

//fix up data
$newname = strtoupper($newname);
$newscore =  ltrim($newscore, "0");

$filename="HiScores.txt";
$fp=fopen($filename,"r") or die("unable to open file $filename");

//read in all data
$array=array();
while(!feof($fp)) {
    $line = removeWhiteSpace(fgets($fp));
#    $array[] = explode(",", $line);
#   array_push($array,  explode(",", $line));

#   print("* ".$line.PHP_EOL); //DEBUG
    //WHY is there an empty line at the end??
    if (strlen($line) == 0) continue;
    list($key, $value) = explode(",", $line);
    $array[$key] = $value;
}
fclose($fp);

//See if name already exists
if (isset($array[$newname])){
    $oldvalue = $array[$newname];
    if ($newscore <= $oldvalue) {
        die("no change required");
    }
}

$array[$newname] = $newscore;

arsort($array);

//print_r($array); //DEBUG

$fp=fopen($filename,"w") or die("unable to open file $filename");

//write out first 10 elements of array
$i = 0;
foreach($array as $name => $value) {
  fwrite($fp,$name.",".$value.PHP_EOL);
  $i++;
  //print($i." ".$name.PHP_EOL); //DEBUG
  if ($i == 10) break;
}

fclose($fp);
print("HiScores file updated");
/***********************************************/
?>
