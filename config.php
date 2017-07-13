<?php
/**
 * RockMongo configuration
 *
 * Defining default options and server configuration
 * @package rockmongo
 */
$MONGO = array();
$MONGO["features"]["log_query"] = "on";//log queries
$MONGO["features"]["theme"] = "default";//theme
$MONGO["features"]["plugins"] = "on";//plugins

$seeds = array();
$mongo_hosts = explode(",", getenv("MONGO_HOSTS"));
for ($i = 0; $i < count($mongo_hosts); $i++) {
    $host_port = explode(":", $mongo_hosts[$i]);

    $seeds[$i]["name"] = explode(".", $host_port[0])[0];
    $seeds[$i]["host"] = $host_port[0];
    $seeds[$i]["port"] = 27017;
    if (count($host_port) > 1) {
        $seeds[$i]["port"] = $host_port[1];
    }
}

for ($i = 0; $i < count($seeds); $i++) {
    /**
    * Configuration of MongoDB servers
    *
    * @see more details at http://rockmongo.com/wiki/configuration?lang=en_us
    */
    $MONGO["servers"][$i]["mongo_name"] = $seeds[$i]["name"];//mongo server name
    //$MONGO["servers"][$i]["mongo_sock"] = "/var/run/mongo.sock";//mongo socket path (instead of host and port)
    $MONGO["servers"][$i]["mongo_host"] = $seeds[$i]["host"];//mongo host
    $MONGO["servers"][$i]["mongo_port"] = $seeds[$i]["port"];//mongo port
    $MONGO["servers"][$i]["mongo_timeout"] = 0;//mongo connection timeout
    //$MONGO["servers"][$i]["mongo_db"] = "MONGO_DATABASE";//default mongo db to connect, works only if mongo_auth=false
    if (getenv("MONGO_AUTH") === 'true') {
        if (getenv("MONGO_USER") !== false) {
            $MONGO["servers"][$i]["mongo_user"] = getenv("MONGO_USER"); //mongo authentication user name, works only if mongo_auth=false
            $MONGO["servers"][$i]["mongo_pass"] = getenv("MONGO_PASSWORD"); //mongo authentication password, works only if mongo_auth=false
        }
        $MONGO["servers"][$i]["mongo_auth"] = true; //enable mongo authentication?
        $MONGO["servers"][$i]["control_auth"] = false; //enable control users, works only if mongo_auth=false
    } else {
        $MONGO["servers"][$i]["mongo_auth"] = false; //enable mongo authentication?
        $MONGO["servers"][$i]["control_auth"] = true; //enable control users, works only if mongo_auth=false
        IF (getenv("ROCKMONGO_USER") !== false && getenv("ROCKMONGO_PASSWORD") !== false) {
            $MONGO["servers"][$i]["control_users"][getenv("ROCKMONGO_USER")] = getenv("ROCKMONGO_PASSWORD"); //one of control users ["USERNAME"]=PASSWORD, works only if mongo_auth=false
        } else {
            $MONGO["servers"][$i]["control_users"]["admin"] = "admin"; //one of control users ["USERNAME"]=PASSWORD, works only if mongo_auth=false
        }
    }
    $MONGO["servers"][$i]["ui_only_dbs"] = ""; //databases to display
    $MONGO["servers"][$i]["ui_hide_dbs"] = ""; //databases to hide
    $MONGO["servers"][$i]["ui_hide_collections"] = ""; //collections to hide
    $MONGO["servers"][$i]["ui_hide_system_collections"] = getenv("MONGO_HIDE_SYSTEM_COLLECTIONS") === "true"? true: false; //whether hide the system collections
    //$MONGO["servers"][$i]["docs_nature_order"] = false;//whether show documents by nature order, default is by _id field
    //$MONGO["servers"][$i]["docs_render"] = "default";//document highlight render, can be "default" or "plain"
}
?>
