<?php
/* 
 * Credential Interface
 */
 if(!ONYX_ACCESS) die('Access Denied');
interface IOnyxCreds{
    const HOST = 'localhost';
    const USER = 'root';
    const PASS = '';
    const DB = 'onyx';
    const ENV = 'LIVE';
    const CONNECTION = 'MySQL';
}
