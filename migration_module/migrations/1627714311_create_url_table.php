<?php

$pull = "CREATE TABLE urlTable (id serial PRIMARY KEY ,
                                    token varchar (10) UNIQUE ,
                                    longUrl text,
                                    created_at timestamp DEFAULT now())";

$rollback = "DROP TABLE urlTable";

return [
    'pull' => $pull,
    'rollback' => $rollback
];