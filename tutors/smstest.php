<?php
include("../includes/pttec_includes.phtml");
MySQL_PaulTheTutor_Connect();

echo send_sms($_GET['tid'], $_GET['msg']) ? "true" : "false";
