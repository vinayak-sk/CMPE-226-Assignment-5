<?php
$hostname = "localhost";
$username = "root";
$password = "sesame";

 class Gym {
    private $gym_id;
    private $gym_name;
    private $gym_latitude;
    private $gym_longitude;
    private $name;
    private $user_id;

    public function get_gym_id() {
      return $this->gym_id;
    }

    public function get_gym_name() {
      return $this->gym_name;
    }

    public function get_gym_latitude() {
      return $this->gym_latitude;
    }

    public function get_gym_longitude() {
      return $this->gym_longitude;
    }

    public function get_gym_owner(){
        return $this->name;
    }

    public function get_gym_owner_user_id(){
        return $this->user_id;
    }
  }


 function createTableRow(Gym $g)
        {
            print "        <tr >\n";
            print "            <td>" . $g->get_gym_owner_user_id()     . "</td>\n";
            print "            <td>" . $g->get_gym_owner() . "</td>\n";
            print "            <td>" . $g->get_gym_name()  . "</td>\n";
            print "        </tr>\n";
        }
 
try {
    $con = new PDO("mysql:host=$hostname;dbname=ChaoticCoders", $username, $password);
    //echo "Connected to database"; // check for connection

    $gymId = $_POST["gymId"];

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
 
    $query = "SELECT GM.USER_ID as user_id, U.NAME as name, G.GYM_NAME as gym_name FROM USER AS U, GYM AS G, GYM_MASTERS AS GM WHERE GM.USER_ID=U.USER_ID AND GM.GYM_ID=$gymId AND G.GYM_ID = GM.GYM_ID";

    $data = $con->query($query);
    $data->setFetchMode(PDO::FETCH_CLASS, "Gym");
    $data->setFetchMode(PDO::FETCH_CLASS, "User");

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
    $ps->setFetchMode(PDO::FETCH_CLASS, "Gym");

    while ($gym = $ps->fetch()) {
                print "        <tr>\n";
                createTableRow($gym);
                print "        </tr>\n";
            }
            
    print "    </table>\n";

    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
?>