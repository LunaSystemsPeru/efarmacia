<?php
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Greenter\Model\DocumentInterface;
use Greenter\Report\XmlUtils;

class Config
{
    private $ruc;
    private $usersol;
    private $clavesol;

    /**
     * Config constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param mixed $ruc
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    /**
     * @param mixed $usersol
     */
    public function setUsersol($usersol)
    {
        $this->usersol = $usersol;
    }

    /**
     * @param mixed $clavesol
     */
    public function setClavesol($clavesol)
    {
        $this->clavesol = $clavesol;
    }

    public function getSee()
    {
        $see = new See();
        $see->setCertificate(file_get_contents(__DIR__ . '/c'.$this->ruc.'.pem'));
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setClaveSOL($this->ruc, $this->usersol, $this->clavesol);
        return $see;
    }

    public function getHash(DocumentInterface $document): ?string
    {
        $see = $this->getSee();
        $xml = $see->getXmlSigned($document);

        return (new XmlUtils())->getHashSign($xml);
    }



}