<?php
function fetchUsername($email) {
    $query = pg_query($GLOBALS['connection'], "SELECT username FROM user_web WHERE email = '$email'");
    if ($query) {
        $row = pg_fetch_array($query);
        return $row['username'] ?? null;
    }
    return null;
}
