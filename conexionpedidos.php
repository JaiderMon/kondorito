<?php

$conn = pg_connect("
host=aws-1-us-east-1.pooler.supabase.com
port=5432
dbname=postgres
user=postgres.udzurkobychnrjqtffle
password=4irmZKBtN1Li019F
");

if (!$conn) {

    die('Error de conexión');

}

?>