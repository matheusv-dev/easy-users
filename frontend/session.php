<?php
// // server should keep session data for AT LEAST 6 hours
ini_set('session.gc_maxlifetime', 21600);

// // each client should remember their session id for EXACTLY 6 hours
session_set_cookie_params(21600);

set_time_limit(0);

@session_start();
