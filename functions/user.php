<?php

function getCurrentUserId()
{
    $userid = random_int(0, time());

    if (isset($_SESSION['userid'])) {
        $userid = (int)$_SESSION['userid'];

    } 

    
    return $userid;
}


function isLoggedIn():bool {
    
    return isset($_SESSION['userid']);
}

function getEmailAdress() {
    $userID = getCurrentUserId();
    $sql = "SELECT email FROM kunde WHERE kundenid = '".$userID."'";
    $result = db_query($sql);
    $email = "";
    while ($row = mysqli_fetch_row($result)) {
        $email = $row[0];
    }
    return $email;
}


function getUserData($email):array {

    
    $sql = "SELECT kundenid, passwort, vorname, nachname, email, telefonnummer, strasse, hausnummer, addinfo, land, ort, plz FROM kunde, adressen WHERE kunde.adresseid = adressen.adresseid AND email = '".$email."'";
    $stmt = db_query($sql);
    if (false === $stmt) {
        return [];
    }
    if (0 === $stmt->num_rows) {
        return [];
    }
    $row = $stmt->fetch_row();
    return $row;

}


function getCurrentUserStatus() {
    $userID = getCurrentUserId();
    $sql = "SELECT status FROM kunde WHERE kundenid = '".$userID."'";
    $result = db_query($sql);
    $enum = "";
    while ($row = mysqli_fetch_row($result)) {
        $enum = $row[0];
    }
    return $enum;
}


function getCurrentUserName() {
    $userid = getCurrentUserId();
    $sql = "SELECT vorname, nachname FROM kunde WHERE kundenid = '".$userid."';";
    $result = db_query($sql);
    $name = "";
    $lname = "";
    $rname = "";
    while ($row = mysqli_fetch_row($result)) {
        $name = $row[0];
        $lname = $row[1];
    }
    $rname = $name . " " . $lname;
    return $rname;
}


function getEmail() {
    $userid = getCurrentUserId();
    $sql = "SELECT email FROM kunde WHERE kundenid = '".$userid."';";
    $result = db_query($sql);
    $rname = mysqli_fetch_array($result);
    return $rname;
}

function getUserCount() {
    $sql = "SELECT count(kundenid) FROM kunde";
    $result = db_query($sql);
    $r = mysqli_fetch_column($result);
    return $r;
}