<?php
namespace App\Library;

use Google\Client as gClient;

class GoogleApi
{
    public function getClient()
    {
        $client = new gClient();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setAuthConfig(__DIR__ . '/../../credentials.json');
        $client->setAccessType('offline');
        $client->setRedirectUri('https://cannabis-radiator.test/oauth2');
        $client->setPrompt('select_account consent');
        $client->addScope('https://www.googleapis.com/auth/spreadsheets.readonly');

        return $client;
    }
}
