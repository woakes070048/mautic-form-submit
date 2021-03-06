<?php

namespace Escopecz\MauticFormSubmit\Test\Mautic;

use Escopecz\MauticFormSubmit\Mautic;
use Escopecz\MauticFormSubmit\Mautic\Contact;

class ContactTest extends \PHPUnit_Framework_TestCase
{
    private $baseUrl = 'https://mymautic.com';

    function test_get_contact_from_mautic()
    {
        $mautic = new Mautic($this->baseUrl);
        $contact = $mautic->getContact();

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame(0, $contact->getId());
        $this->assertSame('', $contact->getIp());
    }

    function test_get_id()
    {
        $contactId = 2342;
        $contact = new Contact($contactId);

        $this->assertSame($contactId, $contact->getId());
        $this->assertSame('', $contact->getIp());
    }

    function test_get_ip()
    {
        $contactIp = '345.2.2.2';
        $contact = new Contact(null, $contactIp);

        $this->assertSame($contactIp, $contact->getIp());
        $this->assertSame(0, $contact->getId());
    }

    function test_get_id_from_mtc_id_cookie()
    {
        $contactId = 4344;
        $_COOKIE['mtc_id'] = $contactId;
        $contact = new Contact;

        $this->assertSame($contactId, $contact->getId());
        unset($_COOKIE['mtc_id']);
    }

    function test_get_id_from_mautic_session_id_cookie()
    {
        $contactId = 4344;
        $sessionId = 'slk3jhkn3gkn23lkgn3lkgn';
        $_COOKIE[$sessionId] = $contactId;
        $_COOKIE['mautic_session_id'] = $sessionId;
        $contact = new Contact;

        $this->assertSame($contactId, $contact->getId());
        unset($_COOKIE['mautic_session_id']);
        unset($_COOKIE[$sessionId]);
    }

    function test_get_id_from_cookie_method()
    {
        $contactId = 4344;
        $_COOKIE['mtc_id'] = $contactId;
        $contact = new Contact;

        $this->assertSame($contactId, $contact->getIdFromCookie());
        unset($_COOKIE['mtc_id']);
    }

    function test_get_ip_from_server()
    {
        $contactIp = '345.2.2.2';
        $_SERVER['REMOTE_ADDR'] = $contactIp;
        $contact = new Contact;

        $this->assertSame($contactIp, $contact->getIp());
        unset($_SERVER['REMOTE_ADDR']);
    }

    function test_get_ip_from_server_method()
    {
        $contactIp = '345.2.2.2';
        $_SERVER['REMOTE_ADDR'] = $contactIp;
        $contact = new Contact;

        $this->assertSame($contactIp, $contact->getIpFromServer());
        unset($_SERVER['REMOTE_ADDR']);
    }
}
