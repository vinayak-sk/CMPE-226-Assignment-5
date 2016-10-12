<?php
$hostname = "localhost";
$username = "root";
$password = "sesame";

class Health{
    private $health_center_name;
    private $health_center_id;
    private $potions;
    private $pokeballs;

    public function get_health_center_name() {
      return $this->health_center_name;
    }
    public function get_health_center_id() {
      return $this->health_center_id;
    }
    public function get_potions() {
      return $this->potions;
    }
    public function get_pokeballs() {
      return $this->pokeballs;
    }
}

 function createTableRow(Health $h)
        {
            print "        <tr >\n";
            print "            <td>" . $h->get_health_center_name()     . "</td>\n";
            print "            <td>" . $h->get_health_center_id() . "</td>\n";
            print "            <td>" . $h->get_potions()  . "</td>\n";
            print "            <td>" . $h->get_pokeballs()  . "</td>\n";
            print "        </tr>\n";
        }
 
try {
    $con = new PDO("mysql:host=$hostname;dbname=ChaoticCoders", $username, $password);
    //echo "Connected to database"; // check for connection

    $healthId = $_POST["healthId"];

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
 
    $query = "SELECT HC.HEALTH_CENTER_NAME as health_center_name, HC.HEALTH_CENTER_ID as health_center_id, HR.POTIONS as potions,  HR.POKEBALLS as pokeballs FROM HEALTH_CENTER AS HC, HEALTH_CENTER_RESOURCES AS HR WHERE HC.HEALTH_CENTER_ID = HR.HEALTH_CENTER_ID AND HC.HEALTH_CENTER_ID=$healthId";

    $data = $con->query($query);
    $data->setFetchMode(PDO::FETCH_CLASS, "Health");

    print "    <table border='1'>\n";

    $result = $con->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    print "            <tr>\n";
    foreach ($row as $field => $value) {
            print "                <th>$field</th>\n";
    }
    print "            </tr>\n";

    $ps = $con->prepare($query);

    $ps->execute();
    $ps->setFetchMode(PDO::FETCH_CLASS, "Health");

    while ($health = $ps->fetch()) {
                print "        <tr>\n";
                createTableRow($health);
                print "        </tr>\n";
            }
            
    print "    </table>\n";

    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>