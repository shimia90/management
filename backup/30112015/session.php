<?php
    session_start();
    $_SESSION["user_name"] = $_GET["user_name"];
    $_SESSION["date_search"] = $_GET["date_search"];
    // Add the rest of the post-variables to session-variables in the same manner